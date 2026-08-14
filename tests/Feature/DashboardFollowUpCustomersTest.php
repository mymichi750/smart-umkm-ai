<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardFollowUpCustomersTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_lists_frequent_customer_who_has_not_purchased_today(): void
    {
        $user = User::factory()->create();
        $followUpCustomer = Customer::create(['name' => 'Pelanggan Rutin', 'phone' => '0812-3456-7890']);
        $boughtTodayCustomer = Customer::create(['name' => 'Sudah Belanja', 'phone' => '0812-0000-0000']);
        $occasionalCustomer = Customer::create(['name' => 'Pelanggan Sesekali', 'phone' => '0812-1111-1111']);

        foreach ([1, 2, 3] as $daysAgo) {
            $this->createTransaction($user, $followUpCustomer, $daysAgo);
            $this->createTransaction($user, $boughtTodayCustomer, $daysAgo);
        }

        $this->createTransaction($user, $boughtTodayCustomer, 0);
        $this->createTransaction($user, $occasionalCustomer, 1);
        $this->createTransaction($user, $occasionalCustomer, 2);

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee('Pelanggan Perlu Dihubungi')
            ->assertSee('Pelanggan Rutin')
            ->assertSee('0812-3456-7890')
            ->assertDontSee('Sudah Belanja')
            ->assertDontSee('Pelanggan Sesekali');
    }

    private function createTransaction(User $user, Customer $customer, int $daysAgo): void
    {
        $date = now()->subDays($daysAgo)->setTime(10, 0);

        $transaction = Transaction::create([
            'user_id' => $user->id,
            'customer_id' => $customer->id,
            'invoice' => 'TEST-' . fake()->unique()->numerify('########'),
            'total' => 10_000,
            'paid' => 10_000,
            'change' => 0,
            'items_count' => 1,
        ]);

        $transaction->forceFill([
            'created_at' => $date,
            'updated_at' => $date,
        ])->save();
    }
}
