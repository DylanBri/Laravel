<x-jet-form-simple id="monitoringSettingsForm" submit="validateMonitoringSettingsInformation">
    <x-slot name="form">
        @csrf
        <div class="md:grid md:gap-6 md:grid-cols-1">
            <div class="mt-5 md:mt-0">
                <div class="col-span-6 sm:col-span-4 flex">
                    <!-- Id -->
                    <div class="mr-2 w-24">
                        <label for="id">{{ __('monitoring::monitoring.Id') }}</label>
                        <input id="id" type="text" class="form-input input-text input-disabled" disabled wire:model.defer="monitoring.id"/>
                        @error('monitoring.id') <span class="text-error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Work_site-lot-company_id -->
                    <div class="flex-1 mr-2">
                        <input id="work_site_lot_company_id" type="hidden" wire:model.defer="monitoring.work_site_id"/>
                        <label for="work_site_lot_company_name">{{ __('monitoring::monitoring.Work_site_lot_company_name') }}</label>
                        <input id="work_site_lot_company_name" type="text" class="form-input input-text" wire:model.defer="monitoring.work_site_lot_company_name"/>
                        @error('monitoring.work_site_lot_company_name') <span class="text-error">{{ $message }}</span> @enderror
                    </div>
                    
                    <!-- Market_amount -->
                    <div class="flex-1 mr-2">
                        <label for="total_market_amount">{{ __('monitoring::monitoring.Total_market_amount') }}</label>
                        <input id="total_market_amount" type="number" class="form-input input-text input-disabled" wire:model.defer="monitoring.total_market_amount" disabled step=".01"/>
                        @error('monitoring.total_market_amount') <span class="text-error">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- <div class="col-span-6 sm:col-span-4 flex">
                    <!-- Lot_id -->
                    <div class="flex-1 mr-2">
                        <input id="lot_id" type="hidden" wire:model.defer="monitoring.lot_id"/>
                        <label for="lot_name">{{ __('monitoring::monitoring.Lot_name') }}</label>
                        <input id="lot_name" type="text" class="form-input input-text" wire:model.defer="monitoring.lot_name"/>
                        @error('monitoring.lot_name') <span class="text-error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Work_site_id -->
                    <div class="flex-1 mr-2">
                        <input id="work_site_id" type="hidden" wire:model.defer="monitoring.work_site_id"/>
                        <label for="work_site_name">{{ __('monitoring::monitoring.Work_site_name') }}</label>
                        <input id="work_site_name" type="text" class="form-input input-text" wire:model.defer="monitoring.work_site_name"/>
                        @error('monitoring.work_site_name') <span class="text-error">{{ $message }}</span> @enderror
                    </div>
                </div> --}}

                <div class="col-span-6 sm:col-span-4 flex">
                    <!-- Name -->
                    <div class="flex-1 mr-2">
                        <label for="name">{{ __('monitoring::monitoring.Name') }}</label>
                        <input id="name" type="text" class="form-input input-text" wire:model.defer="monitoring.name"/>
                        @error('monitoring.name') <span class="text-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex-1 mr-2">
                        <!-- Date -->
                        <label for="date">{{ __('monitoring::monitoring.Date') }}</label>
                        <input id="date_show" type="text" class="form-input input-text" wire:model.defer="monitoring.date"/>
                        <input id="date" type="hidden" class="form-input input-text" wire:model.defer="monitoring.date"/>
                        @error('monitoring.date') <span class="text-error">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>

        <div><div class="border-t border-gray-200"></div></div>

        <div class="md:grid md:gap-6 md:grid-cols-2">
            <div class="mt-5 md:mt-0">
                <div class="col-span-6 sm:col-span-4">  
                    <!-- Deposit -->
                    <div class="flex-1 mr-2 flex">
                        <label class="mr-2 mt-3 w-2/3" for="deposit">{{ __('monitoring::monitoring.Deposit') }}</label>
                        <input id="deposit" type="number" class="form-input input-text w-1/3" wire:model.defer="monitoring.deposit" step=".01"/>
                        @error('monitoring.deposit') <span class="text-error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Payment_amount_ttc -->
                    <div class="flex-1 mr-2 flex">
                        <label class="mr-2 mt-3 w-2/3" for="payment_amount_ttc">{{ __('monitoring::monitoring.Payment_amount_ttc') }}</label>
                        <input id="payment_amount_ttc" type="number" class="form-input input-text w-1/3" wire:model.defer="monitoring.payment_amount_ttc" disabled step=".01"/>
                        @error('monitoring.payment_amount_ttc') <span class="text-error">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            <div class="mt-5 md:mt-0">
                <div class="col-span-6 sm:col-span-4">
                    <!-- Modify_market_amount -->
                    <div class="flex-1 mr-2 flex">
                        <label class="mr-2 mt-3 w-2/3" for="total_modify_market_amount">{{ __('monitoring::monitoring.Total_modify_market_amount') }}</label>
                        <input id="total_modify_market_amount" type="number" class="form-input input-text input-disabled w-1/3" wire:model.defer="monitoring.total_modify_market_amount" step=".01" disabled/>
                        @error('monitoring.total_modify_market_amount') <span class="text-error">{{ $message }}</span> @enderror
                    </div>
        
                    <!-- Total_market_amount -->
                    <div class="flex-1 mr-2 flex">
                        <label class="mr-2 mt-3 w-2/3" for="addition_market_amount">{{ __('monitoring::monitoring.Tot_market_amount') }}</label>
                        <input id="addition_market_amount" type="number" class="form-input input-text input-disabled w-1/3" wire:model.defer="monitoring.addition_market_amount" step=".01" disabled/>
                        @error('monitoring.addition_market_amount') <span class="text-error">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>

        <div><div class="border-t border-gray-200"></div></div>

        <div class="md:grid md:gap-6 md:grid-cols-2">
            <div class="mt-5 md:mt-0">
                <div class="col-span-6 sm:col-span-4">
                    <!-- Market_amount -->
                    <div class="flex-1 mr-2 flex">
                        <label class="mr-2 mt-3 w-2/3" for="market_amount">{{ __('monitoring::monitoring.Market_amount') }}</label>
                        <input id="market_amount" type="number" class="form-input input-text w-1/3" wire:model.defer="monitoring.market_amount" step=".01"/>
                        @error('monitoring.market_amount') <span class="text-error">{{ $message }}</span> @enderror
                    </div>
                </div>
                    
                <div class="col-span-6 sm:col-span-4">
                    <!-- Modify_market_amount -->
                    <div class="flex-1 mr-2 flex">
                        <label class="mr-2 mt-3 w-2/3" for="modify_market_amount">{{ __('monitoring::monitoring.Modify_market_amount') }}</label>
                        <input id="modify_market_amount" type="number" class="form-input input-text w-1/3" wire:model.defer="monitoring.modify_market_amount" step=".01"/>
                        @error('monitoring.modify_market_amount') <span class="text-error">{{ $message }}</span> @enderror
                    </div>
                </div>
                    
                <div class="col-span-6 sm:col-span-4">
                    <!-- Tot_market_amount -->
                    <div class="flex-1 mr-2 flex">
                        <label class="mr-2 mt-3 w-2/3" for="tot_market_amount">{{ __('monitoring::monitoring.Tot_market_amount') }}</label>
                        <input id="tot_market_amount" type="number" class="form-input input-text input-disabled w-1/3" wire:model.defer="monitoring.tot_market_amount" step=".01" disabled/>
                        @error('monitoring.tot_market_amount') <span class="text-error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-span-6 sm:col-span-4 flex">        
                    <!-- Account_percent -->
                    <div class="flex-1 mr-2 flex">
                        <label class="mr-2 mt-3 w-1/3" for="account_percent">{{ __('monitoring::monitoring.Account_percent') }}</label>
                        <input id="account_percent" type="number" class="form-input input-text w-1/3" wire:model.defer="monitoring.account_percent" step=".01"/>
                        @error('monitoring.account_percent') <span class="text-error">{{ $message }}</span> @enderror
                    {{-- </div> --}}
        
                    <!-- Account -->
                    {{-- <div class="flex-1 mr-2 flex"> --}}
                        <label class="mr-2 mt-3" for="account">{{-- __('monitoring::monitoring.Account') --}}&nbsp;= </label>
                        <input id="account" type="number" class="form-input input-text w-1/3" wire:model.defer="monitoring.account" step=".01"/>
                        @error('monitoring.account') <span class="text-error">{{ $message }}</span> @enderror
                    </div>
                </div>
                    
                <div class="col-span-6 sm:col-span-4 flex"> 
                    <!-- Account_management_percent -->
                    <div class="flex-1 mr-2 flex">
                        <label class="mr-2 mt-3 w-1/3" for="account_management_percent">{{ __('monitoring::monitoring.Account_management_percent') }}</label>
                        <input id="account_management_percent" type="number" class="form-input input-text w-1/3" wire:model.defer="monitoring.account_management_percent" step=".01"/>
                        @error('monitoring.account_management_percent') <span class="text-error">{{ $message }}</span> @enderror
                    {{-- </div> --}}
        
                    <!-- Account_management -->
                    {{-- <div class="flex-1 mr-2 flex"> --}}
                        <label class="mr-2 mt-3" for="account_management">{{-- __('monitoring::monitoring.Account_management') --}}&nbsp;= </label>
                        <input id="account_management" type="number" class="form-input input-text w-1/3" wire:model.defer="monitoring.account_management" step=".01"/>
                        @error('monitoring.account_management') <span class="text-error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-span-6 sm:col-span-4 flex">                                  
                    <!-- Bank_guarantee -->
                    <div class="flex-1 mr-2 flex">
                        <label class="mr-2 mt-3 w-2/3" for="bank_guarantee">{{ __('monitoring::monitoring.Bank_guarantee') }}</label>
                        <input id="bank_guarantee" type="number" class="form-input input-text w-1/3" wire:model.defer="monitoring.bank_guarantee" step=".01"/>
                        @error('monitoring.bank_guarantee') <span class="text-error">{{ $message }}</span> @enderror
                    </div>
                </div>
        
                
                <div class="col-span-6 sm:col-span-4 flex">
                    <!-- Retention_money_percent -->
                    <div class="flex-1 mr-2 flex">
                        <label class="mr-2 mt-3 w-1/3" class="" for="retention_money_percent">{{ __('monitoring::monitoring.Retention_money_percent') }}</label>
                        <input id="retention_money_percent" type="number" class="form-input input-text w-1/3" wire:model.defer="monitoring.retention_money_percent" step=".01"/>
                        @error('monitoring.retention_money_percent') <span class="text-error">{{ $message }}</span> @enderror
                    {{-- </div> --}}
        
                    <!-- Retention_money -->
                    {{-- <div class="flex-1 mr-2 flex"> --}}
                        <label class="mr-2 mt-3" for="retention_money">{{-- __('monitoring::monitoring.Retention_money') --}}&nbsp;= </label>
                        <input id="retention_money" type="number" class="form-input input-text w-1/3" wire:model.defer="monitoring.retention_money" step=".01"/>
                        @error('monitoring.retention_money') <span class="text-error">{{ $message }}</span> @enderror
                    </div>
                </div>
        
                <div class="col-span-6 sm:col-span-4 flex">
                    <!-- Doc_penality_percent -->
                    <div class="flex-1 mr-2 flex">
                        <label class="mr-2 mt-3 w-1/3" for="doc_penality_percent">{{ __('monitoring::monitoring.Doc_penality_percent') }}</label>
                        <input id="doc_penality_percent" type="number" class="form-input input-text w-1/3" wire:model.defer="monitoring.doc_penality_percent" step=".01"/>
                        @error('monitoring.doc_penality_percent') <span class="text-error">{{ $message }}</span> @enderror
                    {{-- </div> --}}
        
                    <!-- Doc_penality -->
                    {{-- <div class="flex-1 mr-2 flex"> --}}
                        <label class="mr-2 mt-3" for="doc_penality">{{-- __('monitoring::monitoring.Doc_penality') --}}&nbsp;= </label>
                        <input id="doc_penality" type="number" class="form-input input-text w-1/3" wire:model.defer="monitoring.doc_penality" step=".01"/>
                        @error('monitoring.doc_penality') <span class="text-error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-span-6 sm:col-span-4 flex">
                    <!-- Work_penality -->
                    <div class="flex-1 mr-2 flex">
                        <label class="mr-2 mt-3 w-2/3" for="work_penality">{{ __('monitoring::monitoring.Work_penality') }}</label>
                        <input id="work_penality" type="number" class="form-input input-text w-1/3" wire:model.defer="monitoring.work_penality" step=".01"/>
                        @error('monitoring.work_penality') <span class="text-error">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="mt-5 md:mt-0">
                <div class="col-span-6 sm:col-span-4 flex">
                    <!-- Balance -->
                    <div class="flex-1 mr-2 flex">
                        <label class="mr-2 mt-3 w-2/3" for="balance">{{ __('monitoring::monitoring.Balance') }}</label>
                        <input id="balance" type="number" class="form-input input-text input-disabled w-1/3" wire:model.defer="monitoring.balance" step=".01" disabled/>
                        @error('monitoring.balance') <span class="text-error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-span-6 sm:col-span-4 flex">
                    <!-- Is_staged -->
                    <div class="mr-2 mt-2">
                        @component('components.toggle-checkbox', [
                        'id' => 'is_progress', 'modelField' => 'monitoring.is_progress', 'label' => 'monitoring::monitoring.Is_progress'
                        ])
                        @endcomponent
                        @error('monitoring.is_progress') <span class="text-error">{{ $message }}</span> @enderror
                    </div>
        
                    <!-- Progress -->
                    <div class="flex-1 mr-2 flex">
                        <label class="mr-2 mt-3 w-2/3" for="progress">{{ __('monitoring::monitoring.Progress') }}</label>
                        <input id="progress" type="number" class="form-input input-text w-1/3" wire:model.defer="monitoring.progress" step=".01"/>
                        @error('monitoring.progress') <span class="text-error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-span-6 sm:col-span-4 flex">
                    <!-- Deposit_recovery -->
                    <div class="flex-1 mr-2 flex">
                        <label class="mr-2 mt-3 w-2/3" for="deposit_recovery">{{ __('monitoring::monitoring.Deposit_recovery') }}</label>
                        <input id="deposit_recovery" type="number" class="form-input input-text input-disabled w-1/3" wire:model.defer="monitoring.deposit_recovery" step=".01" disabled/>
                        @error('monitoring.deposit_recovery') <span class="text-error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-span-6 sm:col-span-4 flex">
                    <!-- Balance_Du -->
                    <div class="flex-1 mr-2 flex">
                        <label class="mr-2 mt-3 w-2/3" for="balance_du">{{ __('monitoring::monitoring.Balance_du') }}</label>
                        <input id="balance_du" type="number" class="form-input input-text input-disabled w-1/3" wire:model.defer="monitoring.balance_du" step=".01" disabled/>
                        @error('monitoring.balance_du') <span class="text-error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-span-6 sm:col-span-4 flex h-12">&nbsp;</div>
        
                <div class="col-span-6 sm:col-span-4 flex">
                    <!-- Deduction_previous_payment  -->
                    <div class="flex-1 mr-2 flex">
                        <label class="mr-2 mt-3 w-2/3" for="deduction_previous_payment">{{ __('monitoring::monitoring.Deduction_previous_payment') }}</label>
                        <input id="deduction_previous_payment" type="number" class="form-input input-text input-disabled w-1/3" wire:model.defer="monitoring.deduction_previous_payment" disabled step=".01"/>
                        @error('monitoring.deduction_previous_payment') <span class="text-error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-span-6 sm:col-span-4 flex">
                    <!-- Amount_to_pay -->
                    <div class="flex-1 mr-2 flex">
                        <label class="mr-2 mt-3 w-2/3" for="amount_to_pay">{{ __('monitoring::monitoring.Amount_to_pay') }}</label>
                        <input id="amount_to_pay" type="number" class="form-input input-text input-disabled w-1/3" wire:model.defer="monitoring.amount_to_pay" disabled step=".01"/>
                        @error('monitoring.amount_to_pay') <span class="text-error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-span-6 sm:col-span-4 flex">
                    <!-- Balance_to_pay -->
                    <div class="flex-1 mr-2 flex">
                        <label class="mr-2 mt-3 w-2/3" for="balance_to_pay">{{ __('monitoring::monitoring.Balance_to_pay') }}</label>
                        <input id="balance_to_pay" type="number" class="form-input input-text input-disabled w-1/3" wire:model.defer="monitoring.balance_to_pay" disabled step=".01"/>
                        @error('monitoring.balance_to_pay') <span class="text-error">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <x-slot name="actions">
        <div class="@if ($isModal) hidden @endif">
            <button type="submit" class="btn-primary" wire:loading.attr="disabled">
                {{ __('Save') }}
            </button>
        </div>
    </x-slot>

    <x-jet-action-message class="mr-3" on="saved">
        <div class="@if ($isModal) hidden @endif">
            @livewire('components.alert', ['elId' => 'monitoring-form-alert-success', 'type' => 'alert-success'])
        </div>
    </x-jet-action-message>
</x-jet-form-simple>

@include('monitoring::livewire.monitoring.form.update-settings-form-js')
