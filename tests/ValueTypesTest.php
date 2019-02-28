<?php

namespace romanzipp\Seo\Test;

use romanzipp\Seo\Facades\Seo;
use romanzipp\Seo\Helpers\Hook;
use romanzipp\Seo\Structs\Meta;
use romanzipp\Seo\Structs\Title;
use romanzipp\Seo\Test\TestCase;

class ValueTypesTest extends TestCase
{
    public function testBodyNullValue()
    {
        seo()->add(
            Title::make()->body(null)
        );

        $this->assertNull(seo()->getStructs()[0]->getBody()->data());
    }

    public function testBodyEmptyStringValue()
    {
        seo()->add(
            Title::make()->body('')
        );

        $this->assertNull(seo()->getStructs()[0]->getBody()->data());
    }

    public function testZeroStringAttributeValue()
    {
        seo()->add(
            Meta::make()->attr('name', '0')
        );

        $this->assertTrue(seo()->getStructs()[0]->getAttributes()['name']->data() === '0');
    }

    // --- legacy

    public function testZeroIntegerAttributeValue()
    {
        seo()->add(
            Meta::make()->attr('name', 0)
        );

        $this->assertTrue(seo()->getStructs()[0]->getAttributes()['name']->data() === '0');
    }

    public function testNullAttributeValue()
    {
        seo()->add(
            Meta::make()->attr('name', null)
        );

        $this->assertNull(seo()->getStructs()[0]->getAttributes()['name']->data());
    }

    public function testEmptyStringAttributeValue()
    {
        seo()->add(
            Meta::make()->attr('name', '')
        );

        $this->assertNull(seo()->getStructs()[0]->getAttributes()['name']->data());
    }

    public function testEmptySpaceStringAttributeValue()
    {
        seo()->add(
            Meta::make()->attr('name', ' ')
        );

        $this->assertNull(seo()->getStructs()[0]->getAttributes()['name']->data());
    }

    public function testTrueBooleanAttributeValue()
    {
        seo()->add(
            Meta::make()->attr('name', true)
        );

        $this->assertTrue(seo()->getStructs()[0]->getAttributes()['name']->data() === '1');
    }

    public function testFalseBooleanAttributeValue()
    {
        seo()->add(
            Meta::make()->attr('name', false)
        );

        $this->assertTrue(seo()->getStructs()[0]->getAttributes()['name']->data() === '0');
    }

    public function testHookCallbackBodyType()
    {
        Title::hook(
            Hook::make()
                ->onBody()
                ->callback(function ($body) {

                    $this->assertTrue(is_string($body));

                    return $body;
                })
        );

        seo()->add(
            Title::make()->body('My Title')
        );

        Title::clearHooks();
    }

    public function testHookCallbackNullableBodyType()
    {
        Title::hook(
            Hook::make()
                ->onBody()
                ->callback(function ($body) {

                    $this->assertNull($body);

                    return $body;
                })
        );

        seo()->add(
            Title::make()->body(null)
        );

        Title::clearHooks();
    }
}
