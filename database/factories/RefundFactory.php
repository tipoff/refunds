<?php namespace Tipoff\Refunds\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tipoff\Refunds\Models\Refund;
use Tipoff\Support\Support;

class RefundFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Refund::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws \Exception
     */
    public function definition()
    {
        $paymentModal = config('refunds.payment_modal');

        if (!class_exists($paymentModal)) {
            throw new \Exception('Cannot find the modal ' . $paymentModal);
        }

        $payment = $paymentModal::factory()->create();

        return [
            'amount'     => rand(1000, 2000),
            'method'     => $this->faker->randomElement([Refund::METHOD_STRIPE, Refund::METHOD_VOUCHER]),
            'payment_id' => $payment->id,
            'creator_id' => Support::randomOrCreate(config('refunds.user_model')),
            'updater_id' => Support::randomOrCreate(config('refunds.user_model')),
        ];
    }
}