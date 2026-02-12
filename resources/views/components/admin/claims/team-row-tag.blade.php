<div wire:key="team-row-{{ $claim->id }}" wire:ignore x-data="{
    showAll: false,
    maxVisible: 3,
    totalUsers: {{ $claim->users->count() }},
    remainingCount() {
        return this.totalUsers > this.maxVisible ? this.totalUsers - this.maxVisible : 0;
    }
}" @click.away="showAll = false" class="assigned-team-wrapper">

    <!-- Stacked Avatars -->
    <div class="d-flex align-items-center people-row" style="min-width: 60px;">
        @foreach($claim->users as $i => $user)
            @if($i < 3)
                <div wire:key="avatar-{{ $claim->id }}-{{ $user->id }}"
                     x-data="{ showTooltip: false }"
                     @mouseenter="showTooltip = true"
                     @mouseleave="showTooltip = false"
                     class="position-relative people-tag"
                     :style="`margin-left: {{ $i > 0 ? '-8px' : '0' }}; z-index: ${showTooltip ? 1001 : {{ 10 - $i }}};`">
                    <a href="javascript:void(0)"
                       @click="showAll = !showAll"
                       x-ref="avatar_{{ $i }}"
                       class="d-block"
                    >
                        <img src="{{ $user->avatarUrl() }}"
                             class="rounded-circle border border-2 border-white"
                             height="32"
                             width="32"
                             alt="{{ $user->fullName() }}"
                             style="object-fit: cover;"
                        />
                    </a>

                    <!-- Individual tooltip on hover -->
                    <div x-show="showTooltip && !showAll"
                         x-anchor.bottom-start="$refs.avatar_{{ $i }}"
                         class="bg-dark text-white px-2 py-1 rounded text-nowrap tooltip-item"
                         x-transition>
                        {{ $user->fullName() }}
                    </div>
                </div>
            @endif
        @endforeach

        <!-- Count Badge for Additional Users -->
        @if($claim->users->count() > 3)
            <div class="position-relative people-count-badge"
                 style="margin-left: -8px; z-index: 5;">
                <a href="javascript:void(0)"
                   @click="showAll = !showAll"
                   class="d-flex justify-content-center align-items-center rounded-circle bg-primary text-white border border-2 border-white"
                   style="width: 32px; height: 32px; font-size: 11px; font-weight: 600; text-decoration: none;">
                    +{{ $claim->users->count() - 3 }}
                </a>
            </div>
        @endif

        <!-- Add Button -->
        <div class="bg-white rounded-circle d-flex justify-content-center align-items-center text-center people-add-tag border border-2 border-white"
             style="width: 32px; height: 32px; margin-left: {{ $claim->users->count() > 0 ? '-8px' : '0' }}; z-index: 4;"
             @click.stop="$wire.OpenClaimAssignModal('{{ $claim->id }}')"
        >
            <i class="fa fa-plus" style="font-size: 12px;"></i>
        </div>
    </div>

    <!-- Expanded View - All Users -->
    <div x-show="showAll"
         x-transition
         class="assigned-team-popup"
         @click.stop>
        <div class="popup-header">
            <strong>Team ({{ $claim->users->count() }})</strong>
            <button @click="showAll = false" class="btn-close-popup">
                <i class="fa fa-times"></i>
            </button>
        </div>
        <div class="popup-content">
            @foreach($claim->users as $user)
                <div wire:key="member-{{ $claim->id }}-{{ $user->id }}" class="team-member-item">
                    <img src="{{ $user->avatarUrl() }}"
                         class="member-avatar"
                         alt="{{ $user->fullName() }}"
                    />
                    <div class="member-info">
                        <div class="member-name">{{ $user->fullName() }}</div>
                        <div class="member-email">{{ $user->email ?? '' }}</div>
                    </div>
                    <span class="member-badge">{{ $user->roleName() ?? $user->userType() }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>

@assets
<style>
    .assigned-team-wrapper {
        position: relative;
        display: inline-block;
    }

    .people-add-tag {
        cursor: pointer;
        transition: all 0.2s ease-in-out;
        background-color: #f5f8fa;
    }
    .people-add-tag:hover {
        background-color: #e9ecef;
        transform: scale(1.05);
    }
    .people-tag img,
    .people-count-badge a {
        cursor: pointer;
        transition: transform 0.2s ease-in-out;
    }
    .people-tag img:hover,
    .people-count-badge a:hover {
        transform: scale(1.1);
    }

    .tooltip-item {
        font-size: 11px;
        z-index: 2000;
        margin-top: 4px;
        white-space: nowrap;
        pointer-events: none;
    }

    .assigned-team-popup {
        position: absolute;
        top: 100%;
        left: 0;
        margin-top: 8px;
        z-index: 1050;
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        width: 240px;
        max-height: 350px;
        overflow-y: auto;
    }

    .popup-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 12px;
        border-bottom: 1px solid #dee2e6;
        background: #f8f9fa;
        border-radius: 8px 8px 0 0;
    }

    .popup-header strong {
        font-size: 12px;
        font-weight: 600;
        color: #1e1e2d;
    }

    .btn-close-popup {
        background: transparent;
        border: none;
        padding: 2px 6px;
        cursor: pointer;
        color: #7e8299;
        font-size: 14px;
        line-height: 1;
        transition: color 0.2s;
    }

    .btn-close-popup:hover {
        color: #1e1e2d;
    }

    .popup-content {
        padding: 8px;
    }

    .team-member-item {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px;
        border-radius: 6px;
        transition: background-color 0.2s;
    }

    .team-member-item:hover {
        background-color: #f8f9fa;
    }

    .member-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
    }

    .member-info {
        flex: 1;
        min-width: 0;
    }

    .member-name {
        font-size: 12px;
        font-weight: 600;
        color: #1e1e2d;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .member-email {
        font-size: 10px;
        color: #7e8299;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .member-badge {
        font-size: 9px;
        padding: 3px 6px;
        background: #1e1e2d;
        color: white;
        border-radius: 4px;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .assigned-team-popup::-webkit-scrollbar {
        width: 5px;
    }

    .assigned-team-popup::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .assigned-team-popup::-webkit-scrollbar-thumb {
        background: #c4c4c4;
        border-radius: 10px;
    }

    .assigned-team-popup::-webkit-scrollbar-thumb:hover {
        background: #999;
    }
</style>
@endassets
