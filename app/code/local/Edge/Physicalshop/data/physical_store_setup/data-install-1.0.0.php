<?php

/**
 * Physical Shop data installation script
 *
 * @author Luís André Franco Marado
 */

try {    
    /**
     * Create Sample Physical Shop User
     */
} catch (Mage_Core_Exception $e) {
    echo $e->getMessage();
    exit;
} catch (Exception $e) {
    echo $e->getMessage();
    exit;
}