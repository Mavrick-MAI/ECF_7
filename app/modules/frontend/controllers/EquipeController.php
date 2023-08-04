<?php
declare(strict_types=1);

namespace WebAppSeller\Modules\Frontend\Controllers;

use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Form;
use WebAppSeller\Models\ChefDeProjet;
use WebAppSeller\Models\CompositionEquipe;
use WebAppSeller\Models\Developpeur;
use WebAppSeller\Models\Equipe;

class EquipeController extends ControllerBase
{
    public function indexAction()
    {

        $equipeList = Equipe::find();
        $listColumnName = ['Nom', 'Prénom', 'Niveau', 'Role'];

        $htmlContent = "<div class='page-header'>";
        $htmlContent .= "<h2>Liste de vos équipes</h2>";
        $htmlContent .= "</div>";

        $htmlContent .= "<div><a class='btn btn-primary' href='equipe/createEditEquipePage'>Créer une équipe</a></div>";

        foreach ($equipeList as $equipe) {

            $htmlContent .= "<h2 class='mt-4' style='float:left;'>".$equipe->getNom()."</h2>";
            $htmlContent .= "<div name='buttonTab'>";
            $htmlContent .= "<a style='float:left;' class='btn mt-4' href='equipe/informationEquipePage?idEquipe=".$equipe->getId()."'><i class='fa-solid fa-eye fa-lg' style='color: #292823;'></i></a>";
            $htmlContent .= "<div name='deleteTab'>";
            $htmlContent .= "<button name='deleteEquipe' style='float:left;' data-id='".$equipe->getId()."' type='button' class='btn mt-4'><i class='fa-solid fa-trash-can fa-lg' style='color: #ed0707;'></i></button>";
            $htmlContent .= "</div>";
            $htmlContent .= "</div>";
            $htmlContent .= "<table class='table'>";
            $htmlContent .= "<thead class='table-dark fs-5'>";
            $htmlContent .= "<tr>";

            foreach ($listColumnName as $colName) {
                $htmlContent .= "<td>$colName</td>";
            }

            $htmlContent .= "</tr>";
            $htmlContent .= "</thead>";
            $htmlContent .= "<tbody class='table-group-divider'>";

            $chefEquipe = $equipe->ChefDeProjet->Collaborateur;

            $htmlContent .= "<tr>";
            $htmlContent .= "<td>".$chefEquipe->getNom()."</td>";
            $htmlContent .= "<td>".$chefEquipe->getPrenom()."</td>";
            $htmlContent .= "<td>".$chefEquipe->getNiveauLibelle()."</td>";
            $htmlContent .= "<td>Chef d'équipe</td>";
            $htmlContent .= "</tr>";

            foreach ($equipe->CompositionEquipe as $dev) {

                $devCompetence = $dev->Developpeur->getCompetenceLibelle();
                $collab = $dev->Developpeur->Collaborateur;

                $htmlContent .= "<tr>";
                $htmlContent .= "<td>".$collab->getNom()."</td>";
                $htmlContent .= "<td>".$collab->getPrenom()."</td>";
                $htmlContent .= "<td>".$collab->getNiveauLibelle()."</td>";
                $htmlContent .= "<td>Développeur ".$devCompetence."</td>";
                $htmlContent .= "</tr>";
            }
            $htmlContent .= "</tbody>";
            $htmlContent .= "</table>";
        }

        $this->view->setVar('htmlContent', $htmlContent);
    }

    public function createEditEquipePageAction()
    {
        $this->assets->addJs(PUBLIC_PATH.'/js/scriptEquipe.js');

        $createForm = new Form();

        $nomEquipeInput = new Text('nomEquipe', ['required' => true]);
        $nomEquipeInput->setLabel('Nom équipe');
        $createForm->add($nomEquipeInput);

        $listChefName = ["Choisir un chef de projet"];
        foreach (ChefDeProjet::find() as $chef) {
            $chefId = $chef->getId();
            $chefPrenomNom = $chef->Collaborateur->getPrenomNom();
            $listChefName[] = [$chefId => $chefPrenomNom];
        }

        $chefDeProjetInput = new Select('chefDeProjet', $listChefName);
        $chefDeProjetInput->setLabel('Chef de projet');
        $createForm->add($chefDeProjetInput);

        $listDevName = ["Choisir un développeur"];
        foreach (Developpeur::find() as $dev) {
            $devId = $dev->getId();
            $devPrenomNom = $dev->Collaborateur->getPrenomNom();
            $listDevName[] = [$devId => $devPrenomNom];
        }

        $dev1Input = new Select('dev1', $listDevName, ['onchange' => 'selectDev(this)']);
        $dev1Input->setLabel('Développeur 1');
        $createForm->add($dev1Input);

        $dev2Input = new Select('dev2', $listDevName, ['onchange' => 'selectDev(this)']);
        $dev2Input->setLabel('Développeur 2');
        $createForm->add($dev2Input);

        $dev3Input = new Select('dev3', $listDevName, ['onchange' => 'selectDev(this)']);
        $dev3Input->setLabel('Développeur 3');
        $createForm->add($dev3Input);

        $submit = new Submit('Valider', ['class' => 'btn btn-success']);
        $createForm->add($submit);

        $htmlContent = "<div class='page-header'>";
        $htmlContent .= "<h2>Création d'une équipe</h2>";
        $htmlContent .= "</div>";

        $htmlContent .= "<form method='post' action='createEquipe'>";
        foreach ($createForm as $element) {
            $htmlContent .= "<div>";
            if ($element->getName() != 'Valider') {
                $htmlContent .= "<label for=''".$element->getName()."' class='me-3'>".$element->label()."</label>";
            }
            $htmlContent .= $element->render();
        }
        $htmlContent .= "<a class='btn btn-danger' href='index'>Annuler</a>";
        $htmlContent .= "</div>";
        $htmlContent .= "</form>";

        $this->view->setVar('htmlContent', $htmlContent);
    }

    public function createEquipeAction()
    {
        /* Vérifie que la requête est de type POST */
        if ($this->request->isPost())
        {
            $idChefEquipe = $this->request->get('chefDeProjet');

            /* Vérifie qu'un chef de projet a bien été sélectionné */
            if ($idChefEquipe != 0)
            {
                $nomEquipe = $this->request->get('nomEquipe');

                /* Créer la nouvelle équipe */
                $equipe = (new Equipe())
                    ->setNom($nomEquipe)
                    ->setIdChefDeProjet($idChefEquipe);

                /* Si l'équipe est correctement inséré en BDD */
                if ($equipe->save())
                {
                    $idDevs[] = $this->request->get('dev1');
                    $idDevs[] = $this->request->get('dev2');
                    $idDevs[] = $this->request->get('dev3');

                    /* Créer les compositions d'équipe */
                    foreach ($idDevs as $idDev)
                    {
                        if ($idDev != 0)
                        {
                            $compositionEquipe = (new CompositionEquipe())
                                ->setIdEquipe($equipe->getId())
                                ->setIdDeveloppeur($idDev);
                            $compositionEquipe->save();
                        }
                    }
                }
            }

        }
        /* Redirige sur la page des équipes */
        $this->response->redirect($this->url->get(VIEW_PATH."/equipe"));
    }
    public function informationEquipePageAction()
    {
        $equipe = Equipe::findFirst($this->request->get('idEquipe'));
        $listColumnName = ['Nom', 'Prénom', 'Niveau', 'Boost de production'];

        $htmlContent = "<div class='page-header'>";
        $htmlContent .= "<h2>Equipe ".$equipe->getNom()."</h2>";
        $htmlContent .= "</div>";

        $htmlContent .= "<h3 class='mt-3'>Chef de projet</h3>";

        $htmlContent .= "<table class='table'>";
        $htmlContent .= "<thead class='table-dark fs-5'>";
        $htmlContent .= "<tr>";

        foreach ($listColumnName as $colName) {
            $htmlContent .= "<td>$colName</td>";
        }

        $boostProduction = $equipe->ChefDeProjet->getBoostProduction();
        $chef = $equipe->ChefDeProjet->Collaborateur;

        $htmlContent .= "</tr>";
        $htmlContent .= "</thead>";
        $htmlContent .= "<tbody class='table-group-divider'>";

        $htmlContent .= "<tr>";
        $htmlContent .= "<td>".$chef->getNom()."</td>";
        $htmlContent .= "<td>".$chef->getPrenom()."</td>";
        $htmlContent .= "<td>".$chef->getNiveauLibelle()."</td>";
        $htmlContent .= "<td>".$boostProduction."%</td>";
        $htmlContent .= "</tr>";
        $htmlContent .= "</tbody>";
        $htmlContent .= "</table>";

        $devFront = [];
        $devBack = [];
        $devBDD = [];
        $indiceProduction = 0;

        $compositionEquipe = $equipe->CompositionEquipe;
        foreach ($compositionEquipe as $membreEquipe)
        {
            $developpeur = $membreEquipe->Developpeur;

            switch ($developpeur->getCompetence()) {
                case "1":
                    array_push($devFront, $developpeur);
                    break;
                case "2":
                    array_push($devBack, $developpeur);
                    break;
                case "3":
                    array_push($devBDD, $developpeur);
                    break;
            }
            $indiceProduction += $developpeur->getIndiceProduction();
        }

        $htmlContent .= $this->createDevTable($devFront, "Front");
        $htmlContent .= $this->createDevTable($devBack, "Back");
        $htmlContent .= $this->createDevTable($devBDD, "Database");

        $indiceProduction = $indiceProduction * (1 + $boostProduction/100);



        $htmlContent .= "<div class='mt-5 fs-3'>Indice de production global : ".$indiceProduction."</div>";

        $this->view->setVar('htmlContent', $htmlContent);

    }

    private function createDevTable($developpeurList, $libelleCompetence) {

        $listColumnName = ['Nom', 'Prénom', 'Niveau', 'Indice de production'];

        $htmlContent = "<h3 class='mt-5'>Developpeurs ".$libelleCompetence."</h3>";

        $htmlContent .= "<table class='table'>";
        $htmlContent .= "<thead class='table-dark fs-5'>";
        $htmlContent .= "<tr>";
        foreach ($listColumnName as $colName) {
            $htmlContent .= "<td>$colName</td>";
        }
        $htmlContent .= "</tr>";
        $htmlContent .= "</thead>";
        $htmlContent .= "<tbody class='table-group-divider'>";

        foreach ($developpeurList as $developpeur) {

            $collaborateur = $developpeur->Collaborateur;

            $htmlContent .= "<tr>";
            $htmlContent .= "<td>".$collaborateur->getNom()."</td>";
            $htmlContent .= "<td>".$collaborateur->getPrenom()."</td>";
            $htmlContent .= "<td>".$collaborateur->getNiveauLibelle()."</td>";
            $htmlContent .= "<td>".$developpeur->getIndiceProduction()."</td>";
            $htmlContent .= "</tr>";
        }

        $htmlContent .= "</tbody>";
        $htmlContent .= "</table>";

        if (empty($developpeurList)) {
            $htmlContent .= "<p class='ms-5 fs-3'>Aucun développeur ".$libelleCompetence."</p>";
        }

        return $htmlContent;
    }

    public function deleteEquipeAction()
    {
        /* Récupère l'équipe à supprimer par son ID */
        $equipe = Equipe::findFirst($this->request->get('idEquipe'));

        /* Si l'équipe existe, supprime d'abord les CompositionEquipe liées à l'équipe */
        if (!empty($equipe)) {
            foreach ($equipe->CompositionEquipe as $compositionEquipe) {
                $compositionEquipe->delete();
            }
        }
        /* Supprime l'équipe */
        $equipe->delete();

        /* Redirige sur la page des équipes */
        $this->response->redirect($this->url->get(VIEW_PATH."/equipe"));
    }

}