<?php

namespace App\View\Components\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\Component;

class Sidebar extends Component
{
    protected $role;
    public array $menus;
    public mixed $segment1,$segment2,$segment3;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->role = Auth::user()->userType();
        $this->segment1 = $request->segment(2);
        $this->segment2 = $request->segment(3);
        $this->segment3 = $request->segment(4);
        $this->menus = $this->generateMenu();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.sidebar');
    }

    protected function generateMenu():array
    {
        return Arr::collapse([
            $this->dashboardSection(),
            $this->insuranceSection(),
            Gate::allows('charts::access')?$this->chartsSection():[],
            Gate::allows('support::mail')?$this->supportSection():[],
            Gate::allows('settings')?$this->userSection():[],
            Gate::allows('settings')?$this->settingSection():[],
        ]);
    }

    protected function insuranceSection():array
    {
       return Arr::collapse([
           Gate::allows('claim::list')?[
               'insurance-tag'=>[
                   'name'=>'Insurance Claim & More',
               ],
               'insurance_claim'=>[
                   'name'=>'Claims',
                   'url'=>route('admin::insurance-claim:list'),
                   'active'=>'insurance-claim',
                   'icon'=>'<i class="ki-duotone ki-brifecase-tick fs-2">
                     <span class="path1"></span>
                     <span class="path2"></span>
                     <span class="path3"></span>
                    </i>',
                   'submenu'=>[]
               ],
           ]:[],
           Gate::allows('claim::import')?$this->importSection():[],
           Gate::allows('claim::grouping')?$this->insuranceSectionGrouping():[],
           Gate::allows('client::list')?$this->customers():[],
       ]);
    }

    protected function chartsSection():array
    {
        return [
            'analytics'=>[
                'name'=>'Analytics',
                'url'=>route('admin::analytics:main'),
                'active'=>'analytics',
                'icon'=>'<i class="ki-duotone ki-chart-pie-simple fs-2">
                 <span class="path1"></span>
                 <span class="path2"></span>
                </i>',
                'submenu'=>[]
            ],
        ];
    }

    public function insuranceSectionGrouping():array
    {
        return [
            'grouping'=>[
                'name'=>'Grouping',
                'url'=>'javascript:void(0)',
                'active'=>'insurance-grouping',
                'icon'=>'<i class="ki-duotone ki-filter-tablet fs-2">
 <span class="path1"></span>
 <span class="path2"></span>
</i>',
                'submenu'=>[
                    'Status'=>[
                        'name'=>'Status',
                        'url'=>route('admin::insurance-grouping:status.list'),
                        'active'=>'status',
                        'submenu'=>[]
                    ],
                    'FollowUp'=>[
                        'name'=>'Follow Up',
                        'url'=>route('admin::insurance-grouping:follow-up'),
                        'active'=>'follow-up',
                        'submenu'=>[]
                    ],
                    'WorkedBy'=>[
                        'name'=>'Worked By',
                        'url'=>route('admin::insurance-grouping:worked-by'),
                        'active'=>'worked-by',
                        'submenu'=>[]
                    ],
                    'EOB_DL'=>[
                        'name'=>'EOB DL',
                        'url'=>route('admin::insurance-grouping:eob-dl'),
                        'active'=>'eob-dl',
                        'submenu'=>[]
                    ],
                    'TaxExcluded'=>[
                        'name'=>'TLF Excluded',
                        'url'=>route('admin::insurance-grouping:tlf-excluded'),
                        'active'=>'tlf-excluded',
                        'submenu'=>[]
                    ],
//                    'Tasks'=>[
//                        'name'=>'Tasks',
//                        'url'=>route('admin::insurance-grouping:tasks'),
//                        'active'=>'tasks',
//                        'submenu'=>[]
//                    ],
                ]
            ],
        ];
    }

    public function customers():array
    {
        return [
            'customers'=>[
                'name'=>'Clients',
                'url'=>route('admin::customers:list'),
                'active'=>'customers',
                'icon'=>'<i class="ki-duotone ki-user fs-2">
														<span class="path1"></span>
														<span class="path2"></span>
													</i>',
                'submenu'=>[]
            ],
        ];
    }

    protected function dashboardSection():array
    {
        return [
            'dashboard-tag'=>[
                'name'=>'Dashboard',
            ],
            'dashboard'=>[
                'name'=>'Dashboard',
                'url'=>route('admin::dashboard'),
                'active'=>'dashboard',
                'icon'=>'<i class="ki-duotone ki-element-11 fs-2">
														<span class="path1"></span>
														<span class="path2"></span>
														<span class="path3"></span>
														<span class="path4"></span>
													</i>',
                'submenu'=>[]
            ],
        ];
    }

    protected function themeSection():array
    {
        return [
            'theme-tag'=>[
                'name'=>'Theme & Pages',
            ],
            'themes'=>[
                'name'=>'Theme',
                'url'=>'javascript:void(0)',
                'active'=>'theme',
                'icon'=>'<i class="ki-duotone ki-element-7 fs-2">
														<span class="path1"></span>
														<span class="path2"></span>
													</i>',
                'submenu'=>[
                    'Pages'=>[
                        'name'=>'Pages',
                        'url'=>route('admin::theme:pages.list'),
                        'active'=>'pages',
                        'submenu'=>[]
                    ],
                ]
            ],
        ];
    }

    protected function supportSection():array
    {
        return [
            'other-tag'=>[
                'name'=>'Contact & Mails',
            ],
            'ContactMail'=>[
                'name'=>'Support',
                'url'=>route('admin::contact.mails'),
                'active'=>'contact',
                'icon'=>'<i class="ki-duotone ki-message-text-2 fs-2">
														<span class="path1"></span>
														<span class="path2"></span>
														<span class="path3"></span>
													</i>',
                'submenu'=>[]
            ],
//            'Subscribers'=>[
//                'name'=>'Subscribers',
//                'url'=>route('admin::subscribers'),
//                'active'=>'subscribers',
//                'icon'=>'<i class="ki-duotone ki-sms fs-2">
//														<span class="path1"></span>
//														<span class="path2"></span>
//													</i>',
//                'submenu'=>[]
//            ],
        ];
    }

    protected function userSection():array
    {
        return [
            'user-tag'=>[
                'name'=>'Users & Administrator',
            ],
            'users'=>[
                'name'=>'Users',
                'url'=>'javascript:void(0)',
                'active'=>'users',
                'icon'=>'<i class="ki-duotone ki-profile-user fs-2">
 <span class="path1"></span>
 <span class="path2"></span>
 <span class="path3"></span>
 <span class="path4"></span>
</i>',
                'submenu'=>[
                    'Team'=>[
                        'name'=>'Team Members',
                        'url'=>route('admin::users:admin.list'),
                        'active'=>'admin',
                        'submenu'=>[]
                    ],
                    'User'=>[
                        'name'=>'Website users',
                        'url'=>route('admin::users:list'),
                        'active'=>'list',
                        'submenu'=>[]
                    ],
                ]
            ],
//            'user_grouping'=>[
//                'name'=>'User Grouping',
//                'url'=>'javascript:void(0)',
//                'active'=>'grouping',
//                'icon'=>'<i class="ki-duotone ki-chart fs-2">
//                                <i class="path1"></i>
//                                <i class="path2"></i>
//                            </i>
//                ',
//                'submenu'=>[
//                    'Country'=>[
//                        'name'=>'Countries',
//                        'url'=>route('admin::grouping:address.countries'),
//                        'active'=>'countries',
//                        'submenu'=>[]
//                    ],
//                ]
//            ],
        ];
    }

    protected function settingSection():array
    {
        return  [
            'setting'=>[
                'name'=>'Setting',
                'url'=>route('admin::settings:general'),
                'active'=>'settings',
                'icon'=>'<i class="ki-duotone ki-switch fs-2">
														<span class="path1"></span>
														<span class="path2"></span>
													</i>',
                'submenu'=>[]
            ],
        ];
        /*
        return [
            'setting-tag'=>[
                'name'=>'Settings & More',
            ],
            'setting'=>[
                'name'=>'Setting',
                'url'=>'javascript:void(0)',
                'active'=>'settings',
                'icon'=> '<i class="ki-duotone ki-menu fs-2">
														<span class="path1"></span>
														<span class="path2"></span>
														<span class="path3"></span>
														<span class="path4"></span>
													</i>',
                'submenu'=>[
                    'General'=>[
                        'name'=>'General',
                        'url'=>route('admin::settings:general'),
                        'active'=>'general',
                        'submenu'=>[]
                    ],
                    'Website'=>[
                        'name'=>'Website',
                        'url'=>route('admin::settings:website'),
                        'active'=>'website',
                        'submenu'=>[]
                    ],
                    'Mail'=>[
                        'name'=>'Mail',
                        'url'=>route('admin::settings:mail'),
                        'active'=>'mail',
                        'submenu'=>[]
                    ],
                    'Scripts'=>[
                        'name'=>'Scripts',
                        'url'=>'javascript:void(0)',
                        'active'=>'scripts',
                        'submenu'=>[
                            'ThirdParty'=>[
                                'name'=>'Third Party',
                                'url'=>route('admin::settings:scripts.third-party'),
                                'active'=>'third-party',
                            ],
                            'Custom'=>[
                                'name'=>'Custom',
                                'url'=>route('admin::settings:scripts.custom'),
                                'active'=>'custom',
                            ],
                        ]
                    ]
                ]
            ],
            'Server'=>[
                'name'=>'Server',
                'url'=>'javascript:void(0)',
                'active'=>'server',
                'icon'=>'<i class="ki-duotone ki-switch fs-2">
														<span class="path1"></span>
														<span class="path2"></span>
													</i>',
                'submenu'=>[
                    'Info'=>[
                        'name'=>'Information',
                        'url'=>route('admin::server.info'),
                        'active'=>'info',
                        'submenu'=>[]
                    ],
                    'Logs'=>[
                        'name'=>'Logs',
                        'url'=>route('admin::server.logs'),
                        'active'=>'logs',
                        'submenu'=>[]
                    ],
                ]
            ],
        ];
        */
    }

    private function blogSection(): array
    {
        return [
            'blog-tag'=>[
                'name'=>'Blog Post & Category',
            ],
            'blog'=>[
                'name'=>'Posts',
                'url'=>'javascript:void(0)',
                'active'=>'blog',
                'icon'=>'<i class="ki-duotone ki-menu fs-2">
														<span class="path1"></span>
														<span class="path2"></span>
														<span class="path3"></span>
														<span class="path4"></span>
													</i>',
                'submenu'=>[
                    'Post'=>[
                        'name'=>'All Posts',
                        'url'=>route('admin::blog:posts'),
                        'active'=>'posts',
                        'submenu'=>[]
                    ],
                    'NewPost'=>[
                        'name'=>'Add New',
                        'url'=>route('admin::blog:posts.add'),
                        'active'=>'post',
                        'submenu'=>[]
                    ],
                ]
            ],
            'category'=>[
                'name'=>'Categories',
                'url'=>'javascript:void(0)',
                'active'=>'blog-category',
                'icon'=>'<i class="ki-duotone ki-color-swatch fs-2">
														<span class="path1"></span>
														<span class="path2"></span>
														<span class="path3"></span>
														<span class="path4"></span>
														<span class="path5"></span>
														<span class="path6"></span>
														<span class="path7"></span>
														<span class="path8"></span>
														<span class="path9"></span>
														<span class="path10"></span>
														<span class="path11"></span>
														<span class="path12"></span>
														<span class="path13"></span>
														<span class="path14"></span>
														<span class="path15"></span>
														<span class="path16"></span>
														<span class="path17"></span>
														<span class="path18"></span>
														<span class="path19"></span>
														<span class="path20"></span>
														<span class="path21"></span>
													</i>',
                'submenu'=>[
                    'All'=>[
                        'name'=>'All Categories',
                        'url'=>route('admin::blog:category'),
                        'active'=>'categories',
                        'submenu'=>[]
                    ],
                    'New'=>[
                        'name'=>'Add New',
                        'url'=>route('admin::blog:category.add'),
                        'active'=>'category',
                        'submenu'=>[]
                    ],
                ]
            ],
            'Tags'=>[
                'name'=>'Tags',
                'url'=>route('admin::blog:tags'),
                'icon'=>'<i class="ki-duotone ki-abstract-41 fs-2">
														<span class="path1"></span>
														<span class="path2"></span>
													</i>',
                'active'=>'blog-tags',
                'submenu'=>[]
            ],
            'Collection'=>[
                'name'=>'Post Collection',
                'url'=>route('admin::post-collection:list'),
                'active'=>'post-collection',
                'icon'=>'<i class="ki-duotone ki-text-align-center fs-2">
														<span class="path1"></span>
														<span class="path2"></span>
														<span class="path3"></span>
														<span class="path4"></span>
													</i>',
                'submenu'=>[]
            ],
            'Advertisement'=>[
                'name'=>'Ads',
                'url'=>route('admin::ads:list'),
                'active'=>'ads-space',
                'icon'=>'<i class="ki-duotone ki-map fs-2">
														<span class="path1"></span>
														<span class="path2"></span>
														<span class="path3"></span>
													</i>',
                'submenu'=>[]
            ],
        ];
    }

    private function importSection():array
    {
        return [
            'import'=>[
                'name'=>'Import',
                'url'=>route('admin::insurance-claim:import'),
                'active'=>'insurance-claim-import',
                'icon'=>'<i class="ki-duotone ki-update-file  fs-2 ">
                     <span class="path1"></span>
                     <span class="path2"></span>
                     <span class="path3"></span>
                     <span class="path4"></span>
                    </i>',
                'submenu'=>[]
            ],
        ];
    }
}
