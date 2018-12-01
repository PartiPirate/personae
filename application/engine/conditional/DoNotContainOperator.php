<?php

/*
 Copyright 208 Cédric Levieux, Parti Pirate

This file is part of Personae.

Personae is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Personae is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Personae.  If not, see <http://www.gnu.org/licenses/>.
*/

class DoNotContainOperator implements IOperator
{
    /**
     * @return <code>true</code> if the evaluation of this operator succeeds
    */
    public function operate($value, $compareTo, $context) {
        if (!is_array($compareTo)) {
            $compareTo = array($compareTo);
        }

        foreach($compareTo as $compareToValue) {
            if (stristr($value, $compareToValue) !== FALSE) return false;
        }
        
        return true;
    }
}

?>