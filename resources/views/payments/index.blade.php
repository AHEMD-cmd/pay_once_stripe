<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Payment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">


                    <form action="payments/redirect" method="post"
                        x-on:submit.prevent="confirmCardPayment"
                        x-data="{
                            stripe: null,
                            cardElement: null,
                            cardError: null,
                        
                            init() {
                                this.stripe = Stripe('{{ config('stripe.key') }}')
                                const elements = this.stripe.elements()
                                this.cardElement = elements.create('card', {})
                                this.cardElement.mount('#card-element')
                        
                            },
                            async confirmCardPayment() {
                        
                                this.cardError = null                        
                        
                                const { paymentIntent, error } = await this.stripe.confirmCardPayment(
                                    '{{ $paymentIntent->client_secret }}', {
                                        payment_method: {
                                            card: this.cardElement,
                                            billing_details: {
                                                email: '{{ auth()->user()->email }}'
                                            }
                                        }
                                    }
                                )
                                if (error) {
                                    if (error.type === 'card_error') {
                                        this.cardError = error.message
                                    }
                                } else {
                                 this.$el.submit()
                                }
                            }
                        
                        }">
                        @csrf

                        <div id="card-element"></div>

                        <div x-show="cardError" x-text="cardError" class="text-red-500 mt-2"></div>

                        <x-primary-button class="mt-3">
                            Make payment
                        </x-primary-button>
                    </form>




                </div>
            </div>
        </div>
    </div>
</x-app-layout>
