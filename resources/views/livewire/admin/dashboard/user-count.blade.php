<div class="col-lg-3 col-6">
    <div class="small-box bg-info">
        <div class="inner">
            <div class="d-flex justify-content-between">

                <h3 wire:loading.delay.remove>{{ $usersCount }}</h3>

                <div wire:loading.delay>
                    <x-animations.ball-rotate />
                </div>

                <select wire:change="getUsersCount($event.target.value)" style="height: 2rem; outline: 2px solid transparent;" class="px-1 rounded border-0" name="" id="">
                    <option value="">Today</option>
                    <option value="30">30 days</option>
                    <option value="60">60 days</option>
                    <option value="360">360 days</option>
                    <option value="MTD">Month to Date</option>
                    <option value="YTD">Year to Date</option>
                </select>
            </div>

            <p>Users</p>
        </div>
        <div class="icon">
            <i class="ion ion-bag"></i>
        </div>
        <a href="{{ route('admin.users') }}" class="small-box-footer">View Users <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
