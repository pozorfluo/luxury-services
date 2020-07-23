<?php

namespace App\Service;

use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;

class DevLog
{
    /**
     * @var array <string, mixed>[] [$field_name => $value]
     */
    private static $data;
    private static $cloner;
    private static $dumper;

    public function __construct($variable = null, ?string $note = null)
    {
        if (self::$cloner === null) {
            self::$cloner = new VarCloner();
        }
        if (self::$dumper === null) {
            self::$dumper = new HtmlDumper();
        }

        if($variable !== null) {
            $this->log($variable, $note);
        }
    }

    /**
     * Return property value.
     */
    public function __get($property)
    {
        return self::$data[$property];
    }

    public function log($variable, ?string $note = null) :self
    {
        $dump = self::$dumper->dump(
            self::$cloner->cloneVar($variable), true
        );
        
        if($note === null ){
            self::$data[] = $dump;
         }else {
            self::$data[$note] = $dump;
        }

        return $this;
    }

    public function getData()
    {
        return self::$data;
    }
}
