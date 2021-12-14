<?php

function update_quality($items) {
    foreach ($items as $item) {
        if ($item->name != 'Aged Brie' && $item->name != 'Backstage passes to a TAFKAL80ETC concert') {
            if ($item->quality > 0) {
                if ($item->name != 'Sulfuras, Hand of Ragnaros') {
                    $item->quality -= 1;
                }
            }
        } else {
            if ($item->quality < 50) {
                $item->quality += 1;
                if ($item->name == 'Backstage passes to a TAFKAL80ETC concert') {
                    if ($item->sellIn < 11) {
                        if ($item->quality < 50) {
                            $item->quality += 1;
                        }
                    }
                    if ($item->sellIn < 6) {
                        if ($item->quality < 50) {
                            $item->quality += 1;
                        }
                    }
                }
            }
        }

        if ($item->name != 'Sulfuras, Hand of Ragnaros') {
            $item->sellIn -= 1;
        }
        if ($item->sellIn < 0) {
            if ($item->name != "Aged Brie") {
                if ($item->name != 'Backstage passes to a TAFKAL80ETC concert') {
                    if ($item->quality > 0) {
                        if ($item->name != 'Sulfuras, Hand of Ragnaros') {
                            $item->quality -= 1;
                        }
                    }
                } else {
                    $item->quality = $item->quality - $item->quality;
                }
            } else {
                if ($item->quality < 50) {
                    $item->quality += 1;
                }
            }
        }
    }
}



#----------------------------
# DO NOT CHANGE THINGS BELOW
#----------------------------

class Item
{
    public $name;
    public $sellIn;
    public $quality;

    public function __construct($name, $sellIn, $quality)
    {
        $this->name = $name;
        $this->sellIn = $sellIn;
        $this->quality = $quality;
    }
}
