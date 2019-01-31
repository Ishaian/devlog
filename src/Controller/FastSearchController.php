<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * Date: 21/10/18
 * Time: 08:49
 */

namespace Controller;

use Model\Announce;
use Model\FastSearchManager;

class FastSearchController extends AbstractController
{
    public function search()
    {
        $search = new FastSearchManager($this->getPdo());
        $announces = $search->selectSearch($q);
        return $this->twig->render('Annonce/announce.html.twig', ['announces' => $announces]);
    }
}
