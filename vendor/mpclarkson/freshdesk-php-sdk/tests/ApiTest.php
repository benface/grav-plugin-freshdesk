<?php
namespace Freshdesk\tests;
use Freshdesk\Api;

/**
 * Api tests
 *
 * @package Freshdesk
 * @category Freshdesk
 * @author Matthew Clarkson <mpclarkson@gmail.com>
 */
class ApiTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->class = Api::class;
    } 

    public function methodsThatShouldExist()
    {
        return [
            ['request'],
        ];
    }

    /**
     * @dataProvider publicPropertiesThatShouldExist
     */
    public function testPublicPropertiesAreAccessible($property)
    {
        $this->assertTrue(property_exists($this->class, $property));
    }

    public function publicPropertiesThatShouldExist()
    {
        return [
            ['agents'],
            ['companies'],
            ['contacts'],
            ['groups'],
            ['tickets'],
            ['conversations'],
            ['categories'],
            ['forums'],
            ['topics'],
            ['comments'],
            ['emailConfigs'],
            ['products'],
            ['businessHours'],
            ['slaPolicies'],
        ];
    }
}
