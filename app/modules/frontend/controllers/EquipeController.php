<?php
declare(strict_types=1);

namespace WebAppSeller\Modules\Frontend\Controllers;

use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Form;
use Phalcon\Validation\Validator\Uniqueness;
use WebAppSeller\Models\ChefDeProjet;
use WebAppSeller\Models\CompositionEquipe;
use WebAppSeller\Models\Developpeur;
use WebAppSeller\Models\Equipe;

class EquipeController extends ControllerBase
{
    /**
     * Action qui génére le HTML pour la page affichant toutes les équipes existantes en BDD
     * avec possibilité de consultation, création, modification et suppression
     */
    public function indexAction()
    {

        // récupère la liste des équipes en BDD
        $equipeList = Equipe::find();

        // liste des entêtes de colonnes pour les tables des équipes
        $listColumnName = ['Nom', 'Prénom', 'Niveau', 'Role'];

        // création du HTML de la page
        // titre de la page
        $htmlContent = "<h1>Liste de vos équipes</h1>";

        // bouton de création d'équipe
        $htmlContent .= "<div><a class='btn btn-primary' href='equipe/createEditEquipePage'>Créer une équipe</a></div>";

        // boucle sur la liste d'équipe pour créer les tables
        foreach ($equipeList as $equipe) {

            // le nom de l'équipe
            $htmlContent .= "<h2 class='mt-4' style='float:left;'>".$equipe->getNom()."</h2>";
            $htmlContent .= "<div name='buttonTab'>";
            // le bouton pour consulter les informations d'une équipe
            $htmlContent .= "<a style='float:left;' class='btn mt-4' title='Consulter cette équipe' href='equipe/informationEquipePage?idEquipe=".$equipe->getId()."'><i class='fa-solid fa-eye fa-lg' style='color: #292823;'></i></a>";
            // le bouton pour modifier une équipe
            $htmlContent .= "<a style='float:left;' class='btn mt-4' title='Modifier cette équipe' href='equipe/createEditEquipePage?idEquipe=".$equipe->getId()."'><i class='fa-regular fa-pen-to-square fa-lg' style='color: #c17d11;'></i></a>";
            //
            $htmlContent .= "<div name='deleteTab'>";
            // le bouton pour supprimer une équipe
            // créer un form dans la div courante qui demande confirmation de la suppression
            $htmlContent .= "<button name='deleteEquipe' style='float:left;' data-id='".$equipe->getId()."' type='button' class='btn mt-4' title='Supprimer cette équipe' ><i class='fa-solid fa-trash-can fa-lg' style='color: #ed0707;'></i></button>";
            $htmlContent .= "</div>";
            $htmlContent .= "</div>";

            // création de la table de l'équipe courante
            $htmlContent .= "<table class='table'>";
            // créer la ligne des entêtes de colonnes
            $htmlContent .= "<thead class='table-dark fs-5'>";
            $htmlContent .= "<tr>";
            // boucle sur la liste des noms de colonnes
            foreach ($listColumnName as $colName) {
                // créer la colonne
                $htmlContent .= "<td>$colName</td>";
            }
            $htmlContent .= "</tr>";
            $htmlContent .= "</thead>";
            // création du corps de la table
            $htmlContent .= "<tbody class='table-group-divider'>";

            // récupère les informations du chef de projet dans la table Collaborateur
            $chefEquipe = $equipe->ChefDeProjet->Collaborateur;

            // créer la ligne du chef de projet en premier dans la table
            $htmlContent .= "<tr class='table-primary'>";
            $htmlContent .= "<td>".$chefEquipe->getNom()."</td>";
            $htmlContent .= "<td>".$chefEquipe->getPrenom()."</td>";
            $htmlContent .= "<td>".$chefEquipe->getNiveauLibelle()."</td>";
            $htmlContent .= "<td>Chef d'équipe <i class='fa-solid fa-crown fa-lg' style='color: #FFD700;'></i></td>";
            $htmlContent .= "</tr>";

            // boucle sur la liste des développeurs appartenant à l'équipe
            foreach ($equipe->CompositionEquipe as $dev) {

                // récupère la compétence du développeur (Front, Back ou Database)
                $devCompetence = $dev->Developpeur->getCompetenceLibelle();
                // récupère les informations du développeur dans la table Collaborateur
                $collab = $dev->Developpeur->Collaborateur;

                // créer la ligne du développeur dans la table
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

        // affecte le html à la vue
        $this->view->setVar('htmlContent', $htmlContent);
    }

    /**
     * Action qui génére le HTML pour la page permettant de créer ou de modifier une équipe en BDD
     */
    public function createEditEquipePageAction()
    {
        // intégre le script JS lié aux équipes pour les select des développeurs
        $this->assets->addJs(PUBLIC_PATH.'/js/scriptEquipe.js');

        // créer le formulaire de création/modification d'équipe
        $createEditForm = new Form();

        // créer le champ pour le nom de l'équipe, le champ ne peut pas être vide à l'envoi
        $nomEquipeInput = new Text('nomEquipe', ['required' => true]);
        $nomEquipeInput->setLabel('Nom équipe');
        $createEditForm->add($nomEquipeInput);

        // créer la liste des chef de projet
        $listChefName = ['' => "Choisir un chef de projet",];
        // boucle sur tous les chefs de projet en BDD
        foreach (ChefDeProjet::find() as $chef) {
            // récupère l'id
            $chefId = $chef->getId();
            // récupère le prénom et le nom
            $chefPrenomNom = $chef->Collaborateur->getPrenomNom();
            // insére le chef de projet dans la liste
            $listChefName[$chefId] = $chefPrenomNom;
        }

        // créer la liste déroulante des chefs de projet avec la liste créée au préalable
        $chefDeProjetInput = new Select('chefDeProjet', $listChefName);
        $chefDeProjetInput->setLabel('Chef de projet');
        $chefDeProjetInput->setAttribute('required', true);

        $createEditForm->add($chefDeProjetInput);

        // créer la liste des développeurs
        $listDevName = ['' => "Choisir un développeur"];
        foreach (Developpeur::find(["order" => "competence"]) as $dev) {
            // récupère l'id
            $devId = $dev->getId();
            // récupère le prénom et le nom
            $devPrenomNom = $dev->Collaborateur->getPrenomNom();
            // récupère la compétence
            $devCompetence = $dev->getCompetenceLibelle();
            // insére le développeur dans la liste
            $listDevName[$devId] = $devPrenomNom." (".$devCompetence.")";
        }

        // créer la liste déroulante pour le développeur 1 avec la liste créée au préalable
        $dev1Input = new Select('dev1', $listDevName, ['onchange' => 'selectDev(this)']);
        $dev1Input->setLabel('Développeur 1');
        $createEditForm->add($dev1Input);

        // créer la liste déroulante pour le développeur 2 avec la liste créée au préalable
        $dev2Input = new Select('dev2', $listDevName, ['onchange' => 'selectDev(this)']);
        $dev2Input->setLabel('Développeur 2');
        $createEditForm->add($dev2Input);

        // créer la liste déroulante pour le développeur 3 avec la liste créée au préalable
        $dev3Input = new Select('dev3', $listDevName, ['onchange' => 'selectDev(this)']);
        $dev3Input->setLabel('Développeur 3');
        $createEditForm->add($dev3Input);

        // créer le bouton d'envoi du formulaire
        $submit = new Submit('Valider', ['class' => 'btn btn-success']);
        $createEditForm->add($submit);

        // récupère l'identifiant de l'équipe dans le cas d'une modification
        $idEquipe = $this->request->get('idEquipe');
        // si l'identifiant équipe existe, il s'agit d'une modification
        if ($idEquipe != null) {
            // récupère l'équipe en BDD à partir de l'identifiant
            $equipe = Equipe::findFirst($idEquipe);
            $nomEquipe = $equipe->getNom();
            $idChefEquipe = $equipe->getIdChefDeProjet();

            // affecte le nom de l'équipe au champ du formulaire
            $nomEquipeInput->setDefault($nomEquipe);
            // affecte le chef de projet de l'équipe au formulaire
            $chefDeProjetInput->setDefault($idChefEquipe);

            // récupère les développeurs liés à l'équipe à partir de l'identifiant d'équipe
            $developpeurs = CompositionEquipe::find([
                'conditions' => 'id_equipe = :idEquipe:',
                'bind' => [
                    'idEquipe' => $idEquipe,
                ],
            ]);

            // affecte les identifiants des développeurs aux listes déroulantes
            $dev1Input->setDefault(!empty($developpeurs[0]) ? $developpeurs[0]->getIdDeveloppeur() : 0);
            $dev2Input->setDefault(!empty($developpeurs[1]) ? $developpeurs[1]->getIdDeveloppeur() : 0);
            $dev3Input->setDefault(!empty($developpeurs[2]) ? $developpeurs[2]->getIdDeveloppeur() : 0);

            // créé le titre de la page pour une modification d'équipe
            $htmlContent = "<div class='page-header'>";
            $htmlContent .= "<h1>Modification d'une équipe</h1>";
            $htmlContent .= "</div>";

            // créé la balise du formulaire qui appelle l'action de création/modification d'équipe
            // un id d'équipe est envoyé dans le cas d'une modification
            $htmlContent .= "<form method='post' action='createEditEquipe?idEquipe=".$idEquipe."' onsubmit='return checkForm()'>";
        } else {

            // créé le titre de la page pour une création d'équipe
            $htmlContent = "<div class='page-header'>";
            $htmlContent .= "<h1>Création d'une équipe</h1>";
            $htmlContent .= "</div>";

            // créé la balise du formulaire qui appelle l'action de création/modification d'équipe
            // aucun id d'équipe est envoyé dans le cas d'une création
            $htmlContent .= "<form method='post' action='createEditEquipe' onsubmit='return checkForm()'>";

        }
        // boucle sur les éléments du formulaire afin de les rendre visible sur la page
        foreach ($createEditForm as $element) {
            $htmlContent .= "<div>";
            // vérifie qu'il ne s'agit pas du bouton 'Valider'
            if ($element->getName() != 'Valider') {
                // créé un label pour l'élément du formulaire courant
                $htmlContent .= "<label for=''".$element->getName()."' class='me-3'>".$element->label()."</label>";
            }
            // génére l'élément courant en une String pour l'afficher en HTML
            $htmlContent .= $element->render();
        }
        // créé le bouton 'Annuler' afin de revenir à la gestion des équipes
        $htmlContent .= "<a class='btn btn-danger ms-2' href='../equipe'>Annuler</a>";
        $htmlContent .= "</div>";
        $htmlContent .= "</form>";

        // envoie la variable contenant le HTML à la vue
        $this->view->setVar('htmlContent', $htmlContent);
    }
    /**
     * Action qui permet de créer ou de modifier une équipe en BDD
     * Dans le cas d'une modification, un identifiant d'équipe est envoyé
     */
    public function createEditEquipeAction()
    {
        // initialisation du message d'erreur
        $errorMessage = "";
        // Vérifie que la requête est de type POST
        if ($this->request->isPost())
        {
            // récupère l'identifiant du chef d'équipe du formulaire
            $idChefEquipe = $this->request->get('chefDeProjet');

            // Vérifie qu'un chef d'équipe a bien été sélectionné
            if (!empty($idChefEquipe))
            {
                // récupère le nom de l'équipe du formulaire
                $nomEquipe = $this->request->get('nomEquipe');

                // récupère le filtre
                $filter = $this->getDI()->getShared('filter');

                // nettoie le nom de l'équipe (enlève les balises HTML, ...)
                $cleanNomEquipe = $filter->sanitize($nomEquipe, 'string');

                $existNomEquipe = Equipe::findFirst([
                    'conditions' => 'nom = :nomEquipe:',
                    'bind' => ['nomEquipe' => $cleanNomEquipe],
                ]);

                // récupère l'identifiant de l'équipe
                $idEquipe = $this->request->get('idEquipe');

                if (empty($existNomEquipe) || (!empty($idEquipe) && $existNomEquipe->getId() === $idEquipe))
                {
                    // récupère les identifiants des développeurs du formulaire
                    $idDevs[] = $this->request->get('dev1');
                    $idDevs[] = $this->request->get('dev2');
                    $idDevs[] = $this->request->get('dev3');
                    // vérifie si l'identifiant d'équipe existe
                    if (!empty($idEquipe)) {
                        // si l'identifiant équipe existe dans la requête, il s'agit d'une modification
                        // nettoie le nom de l'équipe
                        $cleanIdEquipe = $filter->sanitize($idEquipe, 'string');
                        // récupère l'équipe dans la base de données
                        $equipe = Equipe::findFirst($cleanIdEquipe);
                    } else {
                        // si l'identifiant équipe n'existe pas dans la requête, il s'agit d'une création
                        // Créer la nouvelle équipe
                        $equipe = new Equipe();
                    }

                    // nettoie l'identifiant du chef de l'équipe
                    $cleanIdChefEquipe = $filter->sanitize($idChefEquipe, 'string');
                    // affecte les nouvelles informations de l'équipe
                    $equipe
                        ->setNom($cleanNomEquipe)
                        ->setIdChefDeProjet($cleanIdChefEquipe);
                    // vérifie que l'équipe est valide
                    if ($equipe->checkEquipe($idDevs)) {
                        // insère/modifie l'équipe en BDD
                        if ($equipe->save())
                        {
                            // supprime les associations de développeur à l'équipe en BDD
                            foreach ($equipe->CompositionEquipe as $compositionEquipe) {
                                $compositionEquipe->delete();
                            }
                            // boucle sur les identifiants de développeurs reçus du formulaire
                            foreach ($idDevs as $idDev)
                            {
                                // vérifie qu'il s'agit bien d'un identifiant (un id ne peut être inférieur ou égal à 0)
                                if ($idDev > 0)
                                {
                                    // nettoie l'identifiant de développeur courant
                                    $cleanIdDev = $filter->sanitize($idDev, 'string');
                                    // créer la nouvelle association de développeur à l'équipe
                                    $compositionEquipe = (new CompositionEquipe())
                                        ->setIdEquipe($equipe->getId())
                                        ->setIdDeveloppeur($cleanIdDev);
                                    // insère les nouvelles associations de développeur à l'équipe en BDD
                                    $compositionEquipe->save();
                                }
                            }
                            // redirige sur la page des équipes
                            $this->response->redirect($this->url->get(VIEW_PATH."/equipe"));
                        }

                    } else {
                        // message d'erreur si un des developpeur est déjà affecté à une équipe existante avec le meme chef de projet
                        $errorMessage = "Au moins un des développeurs sélectionnés est déjà dans une autre équipe avec le même chef de projet.";
                    }
                } else {
                    // message d'erreur si le nom d'équipe est déjà utilisé
                    $errorMessage = "Le nom d'équipe '".$existNomEquipe->getNom()."' est déjà pris.";
                }
            } else {
                // message d'erreur si aucun chef de projet a été sélectionné
                $errorMessage = "Un chef de projet doit être sélectionné.";
            }
        }
        // vérifie si le message d'erreur contient des informations
        if (!empty($errorMessage)) {
            // envoie le message d'erreur à la vue
            $this->flashSession->error($errorMessage);
            // redirige sur la page de création/modification d'une équipe
            // renvoi aussi les informations précedemment envoyées au formulaire
            $this->dispatcher->forward([
                'action' => 'createEditEquipePage',
                'params' => [
                    'formValues' => [
                        'nomEquipe' => $nomEquipe,
                        'chefDeProjet' => $idChefEquipe,
                        'dev1' => $idDevs[0],
                        'dev2' => $idDevs[1],
                        'dev3' => $idDevs[2],
                    ],
                ],
            ]);
        }
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