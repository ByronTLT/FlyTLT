<?php
namespace FlyTLT\FlyTLT;
use pocketmine\Player;
use pocketmine\Serer;
use pocketmine\entity\Living
use pocketmine\plugin\PluginBase;
use pocketmine\event\entity\{EntityDamageEvent, EntityDamageByEntityEvent};
class FlyTLT extends PluginBase implements Listener{
	public function onLoad:void{
		$this->getLogger()->info("FlyTLT Loading");
	}
	public function onEnable:void{
		$this->getLogger()->info("FlyTLT Enabled");
	}
	public function onDisable:void{
		$this->getLogger()->info("FlyTLT Disabled");
	}
	public function onDamage(EntityDamageEvent $event):void{
        $entity = $event->getEntity();
        if($entity instanceof Player){
			self::reloadNameTag($entity);
            if(!$entity->isCreative() && $entity->getAllowFlight()){
                $entity->setFlying(false);
                $entity->setAllowFlight(false);
                $entity->sendMessage("Fly Disabled You Entered Combat");
            }
        }
    }
	public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool{
		if(!$sender instanceof Player) return false;
        if($sender->hasPermission("flytlt.use")){
        	if(!$sender->getAllowFlight()){
        		$sender->setAllowFlight(true);
                $sender->sendMessage("Fly Enabled");
            }else{
                $sender->setAllowFlight(false);
                $sender->setFlying(false);
                $sender->sendMessage("Fly Disabled");
            }else{
                $sender->sendMessage("No Permission To Use /fly");
                return false;
             }
             return true;
        	}
	}
}
