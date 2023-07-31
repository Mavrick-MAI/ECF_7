<?php
declare(strict_types=1);

namespace WebAppSeller\Modules\Frontend\Controllers;

use WebAppSeller\Models\Client;

class ClientController extends ControllerBase
{

    public function indexAction()
    {
        $clientList = Client::find();
        $listColumnName = $clientList[0]->getModelsMetaData()->getAttributes($clientList[0]);
        array_shift($listColumnName);

        $clientTable = "<table class='table'>";
        $clientTable .= "<thead>";
        $clientTable .= "<tr>";

        foreach ($listColumnName as $colName) {
            if (strpos($colName, "_")) {
                $colName = str_replace("_", " ", $colName);
            }
            $clientTable .= "<td>".ucfirst($colName)."</td>";
        }

        $clientTable .= "</tr>";
        $clientTable .= "</thead>";
        $clientTable .= "<tbody>";

        foreach ($clientList as $client) {
            $clientTable .= "<tr>";
            $clientTable .= "<td>".$client->getRaisonSociale()."</td>";
            $clientTable .= "<td>".$client->getRidet()."</td>";
            $clientTable .= "</tr>";
        }
        $clientTable .= "</tbody>";
        $clientTable .= "</table>";

        $this->view->setVar('table', $clientTable);
    }

}