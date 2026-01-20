<?php

namespace App\Helpers\Quick;

trait QuickConstants
{
    public array $eventRenderMethods = [
        'parentRenderMethod'=>'Quick::main:render',
        'projectRenderMethod'=>'Quick::project:render',
        'projectChangeCategory'=>'Quick::project:category-change',
        'categoryListRenderMethod'=>'Quick::category:render',
        'categoryAddEditMethod'=>'Quick::category:add-edit',
    ];

    public array $projectRenderMethods = [
        'parentRenderMethod'=>'Quick::project::main:render',
    ];
}
