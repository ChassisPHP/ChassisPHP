<?php

namespace Tests\Unit;

use Tests\TestCase;
use ChassisPHP\Framework\ConfigManager;

class ConfigManagerTest extends TestCase
{
    public function testInstanceIsSingleton()
    {
        $this->assertSame(ConfigManager::instance(), ConfigManager::instance());
    }

    public function testReadsEachConfigFileByName()
    {
        $this->assertSame('ChassisPHP Test App', ConfigManager::get('app.name'));
        $this->assertSame('localhost', ConfigManager::get('mail.host'));
    }

    public function testDotNotation()
    {
        $this->assertSame('deep', ConfigManager::get('app.nested.level.value'));
        $this->assertSame(['value' => 'deep'], ConfigManager::get('app.nested.level'));
    }

    public function testMissingKeyReturnsNull()
    {
        $this->assertNull(ConfigManager::get('app.missing'));
        $this->assertNull(ConfigManager::get('missing.file'));
    }

    public function testGetThroughInstance()
    {
        // the container hands out the instance, and callers use ->get()
        $this->assertSame('support@example.com', ConfigManager::instance()->get('mail')['supportAddress']);
    }

    public function testArrayAccess()
    {
        $config = ConfigManager::instance();

        $this->assertTrue(isset($config['app']));
        $this->assertSame('ChassisPHP Test App', $config['app']['name']);
        $this->assertNull($config['missing']);

        $config['runtime'] = ['set' => true];
        $this->assertTrue(ConfigManager::get('runtime.set'));

        unset($config['runtime']);
        $this->assertFalse(isset($config['runtime']));
    }
}
