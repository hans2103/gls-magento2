<?php
/**
 *
 *          ..::..
 *     ..::::::::::::..
 *   ::'''''':''::'''''::
 *   ::..  ..:  :  ....::
 *   ::::  :::  :  :   ::
 *   ::::  :::  :  ''' ::
 *   ::::..:::..::.....::
 *     ''::::::::::::''
 *          ''::''
 *
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Creative Commons License.
 * It is available through the world-wide-web at this URL:
 * http://creativecommons.org/licenses/by-nc-nd/3.0/nl/deed.en_US
 * If you are unable to obtain it through the world-wide-web, please send an email
 * to servicedesk@tig.nl so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future. If you wish to customize this module for your
 * needs please contact servicedesk@tig.nl for more information.
 *
 * @copyright   Copyright (c) Total Internet Group B.V. https://tig.nl/copyright
 * @license     http://creativecommons.org/licenses/by-nc-nd/3.0/nl/deed.en_US
 */

namespace TIG\GLS\Block\Adminhtml\Form\Field;

use Magento\Framework\View\Element\Context;
use Magento\Framework\View\Element\Html\Select;
use TIG\GLS\Model\Config\Source\Carrier\Services as ServicesSource;
use TIG\GLS\Service\ServicesReflectionClass;

class Services extends Select
{
    /** @var $_options */
    // @codingStandardsIgnoreLine
    protected $_options;

    /** @var Services $services */
    private $services;

    /** @var ServicesReflectionClass $servicesReflection */
    private $servicesReflection;

    /**
     * Services constructor.
     *
     * @param Context                 $context
     * @param ServicesSource          $services
     * @param ServicesReflectionClass $servicesReflection
     * @param array                   $data
     */
    public function __construct(
        Context $context,
        ServicesSource $services,
        ServicesReflectionClass $servicesReflection,
        array $data = []
    ) {
        $this->services = $services;
        $this->servicesReflection = $servicesReflection;

        parent::__construct($context, $data);
    }

    /**
     * @return string
     * @throws \ReflectionException
     */
    public function _toHtml()
    {
        $this->listAvailableOptions();

        if (!$this->getOptions()) {
            $this->addOptions();
        }

        $this->setClass('input-select required-entry');
        $this->setExtraParams('style="width: 275px;"');

        return parent::_toHtml();
    }

    private function addOptions()
    {
        foreach ($this->_options as $value => $label) {
            $this->addOption($value, $label);
        }
    }

    /**
     * @param $value
     *
     * @return mixed
     */
    public function setInputName($value)
    {
        return $this->setName($value);
    }

    /**
     * @throws \ReflectionException
     */
    private function listAvailableOptions()
    {
        $methods = $this->services->listAvailableMethods();

        $labels = $this->servicesReflection->getConstants();

        foreach ($methods as $name => $method) {
            $this->_options[$method] = $labels[$name . ServicesSource::GLS_CARRIER_SERVICE_LABEL_OPERATOR];
        }
    }
}
