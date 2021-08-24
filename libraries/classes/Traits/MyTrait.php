<?php

declare(strict_types=1);

namespace PhpMyAdmin\Traits;

use PhpMyAdmin\Message;

trait MyTrait
{
    /**
     * @todo Block user access to some pages
     * @author Bill Nguyen <thuannguyenit@gmail.com>
     */
    public function hasGateIn() {
        $group = '';
        $controller = '';
        $segment = get_called_class();
        if(!$segment) return;
        $segment = explode('\\', $segment);
        $segment = array_reverse($segment);
        if(isset($segment[0])) $controller = str_replace('Controller', '', $segment[0]);
        if(isset($segment[1])) $group = $segment[1];

        global $dbi, $cfg;
        $check = false;
        if(isset($cfg['RestrictedArea'][$group])) {
            if($cfg['RestrictedArea'][$group] === true) {
                $check = true;
            }
            elseif(count($cfg['RestrictedArea'][$group]) > 0 && in_array($controller, $cfg['RestrictedArea'][$group])) {
                $check = true;
            }
        }

        $current = $dbi->getCurrentUserAndHost();

        // Exclude special case
        if(in_array((string)$current[0], ['cto']) && $group === 'Preferences') {
            $check = false;
        }

        if ($check === true) {
            if(!in_array((string)$current[0], ['root', 'pma'])) {
                $this->render('error/generic');
                $this->response->addHTML(
                    Message::error(__('Restricted area, please contact administrator.'))->getDisplay()
                );
                exit();
            }
        }
    }
}
