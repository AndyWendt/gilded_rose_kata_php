<?php

require_once __DIR__ . '/../src/gilded_rose.php';

describe_update_single_normal_item();
describe_single_aged_brie_item();
describe_sulphuras_item();
describe_backstage_pass_item();

function describe_update_single_normal_item()  {
    $createItem = fn($initialSellIn = 5, $initialQuality = 10) => new Item('NORMAL ITEM', $initialSellIn, $initialQuality);

    test('normal item - before sell date', function () use ($createItem) {
        $item = $createItem();
        update_quality([$item]);
        $this->assertSame(4, $item->sellIn);
    });

    test('normal item - on sell date', function () use ($createItem) {
        $item = $createItem(0);
        update_quality([$item]);
        $this->assertSame(8, $item->quality);
    });

    test('normal item - after sell date', function () use ($createItem) {
        $item = $createItem(-10);
        update_quality([$item]);
        $this->assertSame(8, $item->quality);
    });

    test('normal item - of zero quality', function () use ($createItem) {
        $item = $createItem(5, 0);
        update_quality([$item]);
        $this->assertSame(0, $item->quality);
    });
}

function describe_single_aged_brie_item() {
    $createItem = fn($initialSellIn = 5, $initialQuality = 10) => new Item('Aged Brie', $initialSellIn, $initialQuality);

    test('aged brie - before sell date', function () use ($createItem) {
        $item = $createItem();
        update_quality([$item]);
        $this->assertSame(11, $item->quality);
    });

    test('aged brie - before sell date - with max quality', function () use ($createItem) {
        $item = $createItem(5, 50);
        update_quality([$item]);
        $this->assertSame(50, $item->quality);
    });

    test('aged brie - on sell date - near max quality', function () use ($createItem) {
        $item = $createItem(5, 49);
        update_quality([$item]);
        $this->assertSame(50, $item->quality);
    });

    test('aged brie - on sell date - with max quality', function () use ($createItem) {
        $item = $createItem(5, 50);
        update_quality([$item]);
        $this->assertSame(50, $item->quality);
    });

    test('aged brie - after sell date - with max quality', function () use ($createItem) {
        $item = $createItem(5, 50);
        update_quality([$item]);
        $this->assertSame(50, $item->quality);
    });
}

function describe_sulphuras_item() {
    $createItem = fn($initialSellIn = 5, $initialQuality = 80) => new Item("Sulfuras, Hand of Ragnaros", $initialSellIn, $initialQuality);

    test('sulphuras - before sell date', function () use ($createItem) {
        $item = $createItem();
        update_quality([$item]);
        $this->assertSame(80, $item->quality);
    });

    test('sulphuras - on sell date', function () use ($createItem) {
        $item = $createItem(0);
        update_quality([$item]);
        $this->assertSame(80, $item->quality);
    });

    test('sulphuras - after sell date', function () use ($createItem) {
        $item = $createItem(-10);
        update_quality([$item]);
        $this->assertSame(80, $item->quality);
    });
}

function describe_backstage_pass_item() {
    $createItem = fn($initialSellIn = 5, $initialQuality = 10) => new Item('Backstage passes to a TAFKAL80ETC concert', $initialSellIn, $initialQuality);

    test('backstage - long before sell date', function () use ($createItem) {
        $item = $createItem(11);
        update_quality([$item]);
        $this->assertSame(11, $item->quality);
    });

    test('backstage - at max quality', function () use ($createItem) {
        $item = $createItem(11);
        update_quality([$item]);
        $this->assertSame(10, $item->sellIn);
    });

    test('backstage - medium close to sell date (upper bound)', function () use ($createItem) {
        $item = $createItem(10);
        update_quality([$item]);
        $this->assertSame(12, $item->quality);
    });

    test('backstage - medium close to sell date (upper bound) - at max quality', function () use ($createItem) {
        $item = $createItem(10, 50);
        update_quality([$item]);
        $this->assertSame(50, $item->quality);
    });

    test('backstage - medium close to sell date (lower bound)', function () use ($createItem) {
        $item = $createItem(6, 10);
        update_quality([$item]);
        $this->assertSame(12, $item->quality);
    });

    test('backstage - medium close to sell date (lower bound) - at max quality', function () use ($createItem) {
        $item = $createItem(6, 50);
        update_quality([$item]);
        $this->assertSame(50, $item->quality);
    });

    test('backstage - very close to sell date (lower bound)', function () use ($createItem) {
        $item = $createItem(1);
        update_quality([$item]);
        $this->assertSame(13, $item->quality);
    });

    test('backstage - very close to sell date (lower bound) - at max quality', function () use ($createItem) {
        $item = $createItem(1, 50);
        update_quality([$item]);
        $this->assertSame(50, $item->quality);
    });

    test('backstage - very close to sell date (lower bound) - on sell date', function () use ($createItem) {
        $item = $createItem(0);
        update_quality([$item]);
        $this->assertSame(0, $item->quality);
    });

    test('backstage - very close to sell date (lower bound) - after sell date', function () use ($createItem) {
        $item = $createItem(-10);
        update_quality([$item]);
        $this->assertSame(0, $item->quality);
    });
}
