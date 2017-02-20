<?php
namespace LFW\Console\ORM;
use LFW\Console\CommandInterface;
use LFW\Framework\FileSystem\File;

/**
 * Class Addentity
 * @package LFW\Console\ORM
 */
class Addentity implements CommandInterface{
    /**
     * @var string
     */
    private $bundle = '';

    /**
     * @var string
     */
    private $champ = '';

    /**
     * @var string
     */
    private $table = '';

    /**
     * Addentity constructor.
     * @param array $argv
     */
    public function __construct(array $argv){
        $this->bundle = $argv[2];
        $this->champ = $argv[4];
        $this->table = $argv[3];
    }

    public function work(){
        $champs = explode('/', $this->champ);

        $code = "<?php\n";
        $code .= 'namespace Bundles\\'.$this->bundle.'\\Entity;'."\n";
        $code .= 'use LFW\\ORM\\Entity;'."\n\n";
        $code .= 'class '.ucfirst($this->table).' extends Entity{'."\n";

        foreach($champs as $l){
            if(strstr($l, '=')){
                list($name, $type) = explode('=', $l);
            } else {
                $name = $l;
            }
            
            $types[ $name ] = (empty($type)) ? '' : $type;
            $code .= '  protected $'.$l.';'."\n";
        }

        $code .= '}';

        File::create('Bundles/'.$this->bundle.'/Entity/'.ucfirst($this->table).'.php', $code);
        File::create('Bundles/'.$this->bundle.'/Entity/Mapping/'.ucfirst($this->table).'.json', json_encode($types));

        echo 'L\'entité '.ucfirst($this->table).' a bien été créée.'.PHP_EOL;
    }
}