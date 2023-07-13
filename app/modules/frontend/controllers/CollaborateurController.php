<?php
declare(strict_types=1);

namespace WebAppSeller\Modules\Frontend\Controllers;

use WebAppSeller\Models\Collaborateur;

class CollaborateurController extends ControllerBase
{

    public function indexAction()
    {
        $collabList = Collaborateur::find();
        $listColumnName = $collabList[0]->getModelsMetaData()->getAttributes($collabList[0]);
        array_shift($listColumnName);

        $collabTable = "<table class='table'>";
        $collabTable .= "<thead>";
        $collabTable .= "<tr>";

        foreach ($listColumnName as $colName) {
            if (strpos($colName, "_")) {
                $colName = str_replace("_", " ", $colName);
            }
            $collabTable .= "<td>".ucfirst($colName)."</td>";
        }

        $collabTable .= "</tr>";
        $collabTable .= "</thead>";
        $collabTable .= "<tbody>";

        foreach ($collabList as $collaborateur) {
            $collabTable .= "<tr>";
            $collabTable .= "<td>".$collaborateur->getNom()."</td>";
            $collabTable .= "<td>".$collaborateur->getPrenom()."</td>";
            $collabTable .= "<td>".$collaborateur->getNiveau()."</td>";
            $collabTable .= "<td>".$collaborateur->getPrimeEmbauche()."</td>";
            $collabTable .= "</tr>";
        }
        $collabTable .= "</tbody>";
        $collabTable .= "</table>";

        $this->view->setVar('table', $collabTable);
    }

}