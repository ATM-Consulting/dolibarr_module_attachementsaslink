<?php
/* <one line to give the program's name and a brief idea of what it does.>
 * Copyright (C) 2015 ATM Consulting <support@atm-consulting.fr>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * \file    class/actions_attachementsaslink.class.php
 * \ingroup attachementsaslink
 * \brief   This file is an example hook overload class file
 *          Put some comments here
 */

/**
 * Class ActionsAttachementsAsLink
 */
class ActionsAttachementsAsLink
{
	/**
	 * @var array Hook results. Propagated to $hookmanager->resArray for later reuse
	 */
	public $results = array();

	/**
	 * @var string String displayed by executeHook() immediately after return
	 */
	public $resprints;

	/**
	 * @var array Errors
	 */
	public $errors = array();

	/**
	 * Constructor
	 */
	public function __construct()
	{
	}

    function getFormMail($parameters, &$object, &$action, $hookmanager) {
            
        global $langs,$conf;    
            
        $listofpaths=array();
        $listofnames=array();
        $listofmimes=array();    
        
        if (! empty($_SESSION["listofpaths"])) $listofpaths=explode(';',$_SESSION["listofpaths"]);
        if (! empty($_SESSION["listofnames"])) $listofnames=explode(';',$_SESSION["listofnames"]);
        if (! empty($_SESSION["listofmimes"])) $listofmimes=explode(';',$_SESSION["listofmimes"]);
        
        //var_dump($listofpaths,$listofnames,$listofmimes, $object, $parameters);
        
        if(count($listofpaths>0)) {
        
            $langs->load('attachementsaslink@attachementsaslink');
        
            $sep = "<br />\n";
            
            $object->substit['__PERSONALIZED__'].=$sep.$langs->trans('SeeAttachementBelow');
            
            foreach($listofpaths as $k=>$attachement) {
                $checksum = md5($attachement.'/'.$listofmimes[$k].'/'.filesize($attachement));
                $object->substit['__PERSONALIZED__'].=$sep.'<a href="'.dol_buildpath('/attachementsaslink/attachement.php?attachement='.urlencode(substr($attachement, strlen(DOL_DATA_ROOT)) ).'&mime='.urlencode($listofmimes[$k]).'&checksum='.$checksum  ,2).'">'.$listofnames[$k].'</a>';
                
            }
            
            $object->substit['__PERSONALIZED__'].=$sep;
            
            if($conf->global->ATTACHEMENTASLINK_DELETE_ATTACHEMENT) {
                $_SESSION['listofpaths']=array();
                $_SESSION['listofnames']=array();
                $_SESSION['listofmimes']=array();
                
            }
            
        }
        
        
        
    }

	/**
	 * Overloading the doActions function : replacing the parent's function with the one below
	 *
	 * @param   array()         $parameters     Hook metadatas (context, etc...)
	 * @param   CommonObject    &$object        The object to process (an invoice if you are in invoice module, a propale in propale's module, etc...)
	 * @param   string          &$action        Current action (if set). Generally create or edit or null
	 * @param   HookManager     $hookmanager    Hook manager propagated to allow calling another hook
	 * @return  int                             < 0 on error, 0 on success, 1 to replace standard code
	 */
	function doActions($parameters, &$object, &$action, $hookmanager)
	{
		$error = 0; // Error counter
		$myvalue = 'test'; // A result value

		print_r($parameters);
		echo "action: " . $action;
		print_r($object);

		if (in_array('somecontext', explode(':', $parameters['context'])))
		{
		  // do something only for the context 'somecontext'
		}

		if (! $error)
		{
			$this->results = array('myreturn' => $myvalue);
			$this->resprints = 'A text to show';
			return 0; // or return 1 to replace standard code
		}
		else
		{
			$this->errors[] = 'Error message';
			return -1;
		}
	}
}