<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Store.php";
    require_once "src/Brand.php";
    $server = 'mysql:host=localhost;dbname=shoes_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);
    class StoreTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Store::deleteAll();
            Brand::deleteAll();
        }

        function testGetStoreName()
        {
            $test_store = new Store("Payless");
            $result = $test_store->getStoreName();
            $this->assertEquals("Payless", $result);
        }

        function testSave()
        {
            $test_store = new Store("Payless");
            $test_store->save();
            $result = Store::getAll();
            $this->assertEquals($test_store, $result[0]);
        }

        function testDelete()
        {
            $test_store = new Store("Payless");
            $test_store->save();
            $test_store->delete();
            $result = Store::getAll();
            $this->assertEquals([], $result);
        }

        function testUpdate()
        {
            $test_store = new Store("Payless");
            $test_store->save();
            $test_store->update("Paymore");
            $result = Store::getAll()[0];
            $this->assertEquals("Paymore", $result->getStoreName());
        }

        function testFind()
        {
            $test_store = new Store("Payless");
            $test_store->save();
            $result = Store::find($test_store->getId());
            $this->assertEquals($test_store, $result);
        }

        function testAddBrand()
        {
            $test_store = new Store("Payless");
            $test_store->save();
            $test_brand = new Brand("Nike");
            $test_brand->save();
            $test_store->addBrand($test_brand->getId());
            $result = $test_store->getBrands();
            $this->assertEquals([$test_brand], $result);
        }

        function testGetOtherBrands()
        {
            $test_store = new Store("Payless");
            $test_store->save();
            $test_brand = new Brand("Nike");
            $test_brand->save();
            $test_brand2 = new Brand("Reebok");
            $test_brand2->save();
            $test_store->addBrand($test_brand->getId());
            $result = $test_store->getOtherBrands();
            $this->assertEquals([$test_brand2], $result);
        }

    }
