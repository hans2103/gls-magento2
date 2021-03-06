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
 * to servicedesk@totalinternetgroup.nl so we can send you a copy immediately.
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
namespace TIG\GLS\Service\Label;

use TIG\GLS\Api\Shipment\LabelRepositoryInterface;
use TIG\GLS\Model\Shipment\LabelFactory;
use TIG\GLS\Webservice\Endpoint\Label;

class Delete extends ShippingInformation
{
    /**
     * @var LabelFactory
     */
    private $labelFactory;

    /**
     * @var LabelRepositoryInterface
     */
    private $labelRepository;

    /**
     * @var Label\Delete
     */
    private $deleteLabel;

    /**
     * Save constructor.
     *
     * @param LabelFactory             $labelFactory
     * @param LabelRepositoryInterface $labelRepository
     * @param Label\Delete             $deleteLabel
     */
    public function __construct(
        LabelFactory $labelFactory,
        LabelRepositoryInterface $labelRepository,
        Label\Delete $deleteLabel
    ) {
        $this->labelFactory = $labelFactory;
        $this->labelRepository = $labelRepository;
        $this->deleteLabel = $deleteLabel;
    }

    /**
     * @param $shipmentId
     * @param $controllerModule
     * @param $version
     *
     * @throws \Zend_Http_Client_Exception
     */
    public function deleteLabel($shipmentId, $controllerModule, $version)
    {
        $label          = $this->labelRepository->getByShipmentId($shipmentId);
        $data           = $this->addShippingInformation($controllerModule, $version);
        $data['unitNo'] = $label->getUnitNo();

        $this->deleteLabel->setRequestData($data);

        return $this->deleteLabel->call();
    }

    /**
     * @param $shipmentId
     */
    public function deleteLabelByShipmentId($shipmentId)
    {
        $label = $this->labelRepository->getByShipmentId($shipmentId);

        if ($label) {
            $this->labelRepository->delete($label);
        }
    }
}
