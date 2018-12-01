<?php

/*
 Copyright 2018 Cédric Levieux, Parti Pirate

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

class MotionTitleCondition implements ICondition
{
    /**
     * @return <code>true</code> if the evaluation of this condition succeeds
    */
    public function evaluateCondition($condition, $context) {
        $motion = $context["motion"];
        $value = $motion["mot_title"];

        $operator = ConditionalFactory::getOperatorInstance($condition);

        $result = $operator->operate($value, explode(",", $condition["value"]), $context);

        return $result;
    }
}

?>