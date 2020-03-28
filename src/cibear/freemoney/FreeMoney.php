<?php
namespace cibear\freemoney;

use pocketmine\Server;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use pocketmine\event\Listener;
use pocketmine\item\Item;

class FreeMoney extends PluginBase {

	public function onEnable(){
   $this->eco = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");
		$this->getLogger()->info("§2https://github.com/CiBearBot/FreeMoneyPlugin");
		}
		
	public function onDisable(){
		$this->getLogger()->info("§4https://github.com/CiBearBot/FreeMoneyPlugin");
		$this->cooldown->save();
	}
	
	public function onCommand(CommandSender $sender, Command $command, String $label, array $args) : bool {
        switch($command->getName()){
            case "freemoney":
            $this->FormFM($sender);
            return true;
        }
        return true;
	}
	
	public function FormFM($sender){
		$api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createSimpleForm(function (Player $sender, int $data = null){
			$result = $data;
			if($result === null){
				return true;
				}
				switch($result){
                case 0:
				$coin = $this->eco->myMoney($sender);
				if($coin < 1000){
					$rand = mt_rand(100, 2000);
					$this->eco->addMoney($sender, $rand);
					$sender->sendMessage("§f[ §eSystem §f] §aคุณได้รับเงินคนจนจำนวณ§f $rand §a฿");
				}else{
				}
				break;
				case 1:
				break;
				}
			});
			$form->setTitle("FreeMoney");
			$money = $this->eco->myMoney($sender);
			$form->setContent("กดรับเงินเพื่อรับเงินแบบสุ่ม 100-2000\n- คุณต้องมีเงินน้อยกว่า 1000 เท่านั้นทีจะรับได้\n- หากมีมากกว่าระบบจะไม่แสดงข้อความ\n\nYour money: $money");
			$form->addButton("รับเงิน", 0, "textures/blocks/emerald_block");
			$form->addButton("ออก", 0, "textures/blocks/barrier");
			$form->sendToPlayer($sender);
	}
}