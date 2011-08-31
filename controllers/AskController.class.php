<?php
/**
 * Description of AskController
 *
 * @author Oksana
 */
class AskController extends Controller
{
    function viewAll()
    {
        $this->set('market_db',$this->_model->selectAll());
    }

}
?>
