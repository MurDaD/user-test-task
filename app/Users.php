<?php namespace app;
/**
 * Author: MurDaD
 * Author URL: https://github.com/MurDaD
 *
 * Description: Users Class. All the logic goes here
 * Type:
 */

class Users extends Model
{
    protected $_table = 'users';
    private $rating;

    public function __construct($id = null)
    {
        parent::__construct();
        if($id && is_numeric($id)) {
            return parent::find($id);
        } else {
            return null;
        }
    }

    private function calculateCountryRank()
    {
        checkEntity();
        switch($this->country) {
            case 'Hungary';
                $this->rating += 2;
                break;
            case 'Germany';
                $this->rating += 3;
                break;
            case 'France';
                $this->rating += 4;
                break;
            case 'Russia';
                $this->rating += 5;
                break;
            case 'Ukraine';
                $this->rating += 6;
                break;
            case 'Bulgaria';
                $this->rating += 7;
                break;
            default:
                break;
        }
    }

    private function calculateIDRank()
    {
        checkEntity();
        if($this->id % 3 == 0) {
            $this->rating++;
        }
        if($this->id % 4 == 0) {
            $this->rating += 2;
        }
    }

    public function calculateRank()
    {
        $this->calculateCountryRank();
    }
}