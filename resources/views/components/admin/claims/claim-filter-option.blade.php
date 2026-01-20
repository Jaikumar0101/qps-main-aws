<div wire:ignore
     x-data="{
       filters:@js($filters),
       selectedFilter:@entangle('selectedCustomFilter'),
       labels:@js(\App\Helpers\Claims\ClaimFilterHelper::filterKeysLabel()),
       show:false,
       toggleShow:function(){
         this.show = !this.show;
       }
     }"
     x-init="
       console.log(selectedFilter)
     "
     x-cloak
     class="position-relative"
     @click.away="show = false"
>
    <button type="button"
            class="btn btn-sm btn-flex btn-secondary fw-bold"
            @click="toggleShow"
    >
        <i class="ki-duotone ki-filter fs-6 text-muted me-1">
            <span class="path1"></span>
            <span class="path2"></span>
        </i>
        <span class="filter-text">Filter</span>
    </button>
    <div class="filterShowcase"
         x-show="show"
    >
        <div class="form-group">
            <label>Filter Option</label>
            <select class="filter-select"
                    x-model="selectedFilter"
            >
                <template x-for="(item,key) in filters">
                    <option :value="key" x-text="labels[key]"></option>
                </template>
            </select>
        </div>
    </div>
</div>

@assets
<style>
    .filterShowcase{
        position: absolute;
        top: 110%;
        right: 0;
        min-width: 300px;
        min-height: 350px;
        background-color: white;
        z-index: 99;
        border: 1px solid #dee2e6!important;
        border-radius: 5px;
        box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px;
        padding: 20px 10px 20px 10px;
    }
    .filter-select{
        padding: 5px 10px;
        width: 100%;
    }
</style>
@endassets
