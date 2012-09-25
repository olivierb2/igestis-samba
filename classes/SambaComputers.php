<?php

namespace Igestis\Modules\Samba;

use Igestis\Utils\Dump;

use Igestis\Utils\Debug;

/**
 * Thie class is designed to update all samba fields in the ldap database
 *
 * @author Gilles Hemmerlé
 */
class SambaComputers {
    public function listComputers() {
      
      try {
        // Connect the ldap database
        $ldap = new \LDAP(\ConfigIgestisGlobalVars::LDAP_URIS, ConfigModuleVars::LDAP_COMPUTER_OU);
        $ldap->bind(\ConfigIgestisGlobalVars::LDAP_ADMIN, \ConfigIgestisGlobalVars::LDAP_PASSWORD);
        
        // Get the list of computers
        $computer_ou_tree = $ldap->find("(objectClass=sambaSamAccount)", array("uid", "sambaSID", "uidNumber", "gidNumber"));
        $computers_dn = array();
        
        foreach($computer_ou_tree as $dn => $entry){ // Pour chaque entrée
              foreach($entry as $attr => $values){ // pour chaque attribut
                foreach($values as $value){// pour chaque valeur
                  array_push($computer_info[$attr] = $value);
                }
                array_push($computers_dn[$dn] = $computer_info);
              }
        }
        
        
      } catch (Exception $exc) {
        throw new Exception($exc);
      }
      
      Debug::addDump($computers_dn,"computer",3);
      
      return $computers_dn;

      
    }
  
  
}