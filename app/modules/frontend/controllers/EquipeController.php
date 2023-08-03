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

        foreach ($equipeList as $equipe) {

            $equipeHTML .= "<h2 class='mt-4' style='float:left;'>".$equipe->getNom()."</h2>";
            $equipeHTML .= "<div name='deleteTab'>";
            $equipeHTML .= "<button name='deleteEquipe' style='float:left;' data-id='".$equipe->getId()."' type='button' class='btn mt-4'><i class='fa-solid fa-trash-can' style='color: #ed0707;'></i></button>";
            $equipeHTML .= "</div>";
            $equipeHTML .= "<table class='table'>";
            $equipeHTML .= "<thead class='table-dark fs-5'>";
            $equipeHTML .= "<tr>";

            foreach ($listColumnName as $colName) {
                $equipeHTML .= "<td>$colName</td>";
            }

            $equipeHTML .= "</tr>";
            $equipeHTML .= "</thead>";
            $equipeHTML .= "<tbody class='table-group-divider'>";

            $chefEquipe = $equipe->ChefDeProjet->Collaborateur;

            $equipeHTML .= "<tr>";
            $equipeHTML .= "<td>".$chefEquipe->getNom()."</td>";
            $equipeHTML .= "<td>".$chefEquipe->getPrenom()."</td>";
            $equipeHTML .= "<td>".$chefEquipe->getNiveauLibelle()."</td>";
            $equipeHTML .= "<td>Chef d'équipe</td>";
            $equipeHTML .= "</tr>";

            foreach ($equipe->CompositionEquipe as $dev) {

                $devCompetence = $dev->Developpeur->getCompetenceLibelle();
                $collab = $dev->Developpeur->Collaborateur;

                $equipeHTML .= "<tr>";
                $equipeHTML .= "<td>".$collab->getNom()."</td>";
                $equipeHTML .= "<td>".$collab->getPrenom()."</td>";
                $equipeHTML .= "<td>".$collab->getNiveauLibelle()."</td>";
                $equipeHTML .= "<td>Développeur ".$devCompetence."</td>";
                $equipeHTML .= "</tr>";
            }
            $equipeHTML .= "</tbody>";
            $equipeHTML .= "</table>";
        }

        $this->view->setVar('equipe', $equipeHTML);
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

        $html = "<form method='post' action='createEquipe'>";
        foreach ($createForm as $element) {
            $html .= "<div>";
            if ($element->getName() != 'Valider') {
                $html .= "<label for=''".$element->getName()."' class='me-3'>".$element->label()."</label>";
            }
            $html .= $element->render();
        }
        $html .= "<a class='btn btn-danger' href='index'>Annuler</a>";
        $html .= "</div>";
        $html .= "</form>";

        $this->view->setVar('create', $html);
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