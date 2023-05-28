<?php

namespace App\Http\Livewire\Admin\Dashboard;

use App\Models\User;
use Livewire\Component;

use function PHPUnit\Framework\returnSelf;

class UserCount extends Component
{
    public $usersCount;

    public function mount()
    {
        $this->getUsersCount(null);
    }

    public function getUsersCount($option)
    {
        $this->usersCount = User::query()
            ->when($option, function ($query, $option) {
                return $query->whereBetween('created_at', $this->getDateRange($option));
            }, function ($query) {
                return $query->whereBetween('created_at', [now()->today(), now()]);
            })->count();
    }

    public function getDateRange($option)
    {
        if ($option === 'MTD') {
            return [now()->firstOfMonth(), now()];
        } elseif ($option === 'YTD') {
            return [now()->firstOfYear(), now()];
        }
        return [now()->subDays($option), now()];
    }

    public function render()
    {
        return view('livewire.admin.dashboard.user-count');
    }
}
