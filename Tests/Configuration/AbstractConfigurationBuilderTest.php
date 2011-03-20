<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2010-2011 punkt.de GmbH - Karlsruhe, Germany - http://www.punkt.de
 *  Authors: Daniel Lienert, Michael Knoll, Christoph Ehscheidt
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

require_once t3lib_extMgm::extPath('pt_extlist') . 'Classes/Domain/Configuration/ConfigurationBuilder.php';
require_once t3lib_extMgm::extPath('pt_extbase') . 'Classes/Configuration/AbstractConfigurationBuilder.php';
require_once t3lib_extMgm::extPath('pt_extlist') . 'Classes/Domain/Configuration/AbstractConfiguration.php';

/**
 * Testcase for abstract configuration builder class
 *
 * @package Tests
 * @subpackage Configuration
 * @author Michael Knoll 
 */
class Tx_PtExtbase_Tests_Configuration_AbstractConfigurationBuilderTest extends Tx_PtExtbase_Tests_AbstractBaseTestcase {

	/**
	 * Holds an array of settings for testing
	 *
	 * @var array
	 */
	protected $settings = array('testKey' => array('key1' => 'value1'));
	
	
	
	/**
	 * Holds a dummy implementation of abstract configuration builder for testing
	 *
	 * @var Tx_PtExtlist_Tests_Domain_Configuration_AbstractConfigurationBuilder_Stub
	 */
	protected $fixture;
	
	
	
	/** @test */
	public function setUp() {
		$this->fixture = new Tx_PtExtbase_Tests_Configuration_AbstractConfigurationBuilder_Stub($this->settings);
	}
	
	
	
	/** @test */
	public function genericCallReturnsConfigurationObjectForGivenConfiguration() {
		$configurationObject = $this->fixture->buildDummyConfiguration();
		$this->assertTrue(is_a($configurationObject, 'Tx_PtExtbase_Tests_Configuration_DummyConfigurationObject'));
		$this->assertEquals($configurationObject->getSettings(), $this->settings['testKey']);
	}
	
}



/**
 * Stub implementation of configuration builder for testing
 */
class Tx_PtExtbase_Tests_Configuration_AbstractConfigurationBuilder_Stub extends Tx_PtExtlist_Domain_Configuration_ConfigurationBuilder {
	
	/**
	 * Set up configuration array for abstract configuration builder
	 *
	 * @var array
	 */
    protected $configurationObjectSettings = array(
        'dummy' => array(
            'factory' => 'Tx_PtExtbase_Tests_Configuration_AbstractConfigurationBuilder_DummyConfigurationObjectfactory',   
        )
    );
    
    
    
    /**
     * We overwrite constructor to prevent error for empty settings array
     */
    public function __construct($configurationBuilder, $settings) {
    	$this->configurationBuilder = $configurationBuilder;
    }
	
}



/**
 * Stub implementation of a configuration object
 */
class Tx_PtExtbase_Tests_Configuration_DummyConfigurationObject extends Tx_PtExtlist_Domain_Configuration_AbstractConfiguration  {
	
}



/**
 * Stub implementation of a configuration object factory
 */
class Tx_PtExtbase_Tests_Configuration_AbstractConfigurationBuilder_DummyConfigurationObjectfactory {
	public function getInstance(Tx_PtExtbase_Tests_Configuration_AbstractConfigurationBuilder_Stub $configurationBuilder) {
		$configObject = new Tx_PtExtbase_Tests_Configuration_DummyConfigurationObject($configurationBuilder, array('key1' => 'value1'));
		return $configObject;
	}
}

?>