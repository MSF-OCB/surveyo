<?php
/**
 * \Elabftw\Elabftw\TeamsView
 *
 * @author Nicolas CARPi <nicolas.carpi@curie.fr>
 * @copyright 2012 Nicolas CARPi
 * @see http://www.elabftw.net Official website
 * @license AGPL-3.0
 * @package elabftw
 */
namespace Elabftw\Elabftw;

use \PDO;

/**
 * HTML for the teams
 */
class TeamsView extends Teams
{
    /** The PDO object */
    protected $pdo;

    /**
     * Constructor
     *
     */
    public function __construct()
    {
        $this->pdo = Db::getConnection();
    }

    /**
     * Output HTML for creating a team
     *
     * @return string $html
     */
    public function showCreate()
    {
        $html = "<h3>" . _('Add a new team') . "</h3>";
        $html .= "<input required type='text' placeholder='Enter new team name' id='teamsName' />";
        $html .= "<button id='teamsCreateButton' onClick='teamsCreate()' class='button'>" . ('Save') . "</button>";

        return $html;
    }

    /**
     * Output HTML with all the teams
     *
     * @param array $teamsArr The output of the read() function
     * @return string $html
     */
    public function show($teamsArr)
    {
        $html = "<h3>" . _('Edit existing teams') . "</h3>";

        foreach ($teamsArr as $team) {
            $count = $this->getStats($team['team_id']);
            $html .= " <input type='text' value='" . $team['team_name'] . "' id='team_" . $team['team_id'] . "' />";
            $html .= " <button id='teamsUpdateButton_" . $team['team_id'] . "' onClick='teamsUpdate(" . $team['team_id'] . ")' class='button'>" . ('Edit') . "</button>";
            if ($count['totusers'] == 0) {
                $html .= " <button id='teamsDestroyButton_" . $team['team_id'] . "' onClick='teamsDestroy(" . $team['team_id'] . ")' class='button'>" . ('Delete') . "</button>";
            } else {
                $html .= " <button id='teamsArchiveButton_" . $team['team_id'] . "' onClick='teamsArchive(" . $team['team_id'] . ")' class='button'>" . ('Archive') . "</button>";
            }
            $html .= "<p>" . _('Members') . ": " . $count['totusers'] . " − " . ngettext('Experiment', 'Experiments', $count['totxp']) . ": " . $count['totxp'] . " − " . _('Items') . ": " . $count['totdb'] . " − " . _('Created') . ": " . $team['datetime'] . "<p>";
        }
        return $html;
    }
}
