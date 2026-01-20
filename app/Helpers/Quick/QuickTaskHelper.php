<?php

namespace App\Helpers\Quick;

use App\Models\QuickProject;
use App\Models\QuickProjectAssign;
use App\Models\QuickProjectSetting;
use Illuminate\Support\Arr;

class QuickTaskHelper
{

    const PROJECT_SETTINGS = [
        'default_tab'=>'dashboard',
    ];

    const PROJECT_TABS = [
        'tasks'=>'Task List',
        'message'=>'Messages',
        'people'=>'People',
        'dashboard'=>'Dashboard',
        'settings'=>'Settings',
    ];

    public static function getProjectSettingKeys():array
    {
        return array_values(array_keys(self::PROJECT_SETTINGS));
    }

    public static function getProjectSettings($project_id = null):array
    {
        $keys = self::getProjectSettingKeys();

        $data = QuickProjectSetting::getByKeys(
            $project_id,
            $keys
        );

        foreach (self::PROJECT_SETTINGS as $key=>$value)
        {
            if (!Arr::has($data,$key))
            {
                $data[$key] = $value;
            }
        }

        return $data;
    }

    public static function saveProjectSetting(QuickProject $project, $data = []):void
    {
        $ids = [];

        foreach ($data as $key=>$value)
        {
            $check = QuickProjectSetting::getByKey($project->id,$key);

            if (!$check)
            {
                $check = new QuickProjectSetting();
                $check->fill([
                    'project_id'=>$project->id,
                    'key'=>$key,
                ]);
            }

            $check->value = $value;
            $check->save();

            $ids[] = $check->id;
        }

        QuickProjectSetting::where('project_id',$project->id)
            ->whereNotIn('id',$ids)
            ->delete();

    }

    public static function assignUserToProject($project_id,$user_id = null):void
    {
        $check = QuickProjectAssign::where([
            'project_id'=>$project_id,
            'user_id'=>$user_id
        ])->count();

        if ($check == 0)
        {
            QuickProjectAssign::create([
                'project_id'=>$project_id,
                'user_id'=>$user_id
            ]);
        }
    }

}
