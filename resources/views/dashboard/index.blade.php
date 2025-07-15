<x-layouts>
    <x-slot:header>
        Dashboard
    </x-slot:header>

    {{-- data --}}
    @php
        $dataCards = [
            'Total Saldo Bonus' => 'Rp 7.250.000',
            'Peringkat Saat Ini' => 'Senior Manager',
            'Downline Langsung' => '5 Orang',
            'Total Jaringan' => '124 Orang',
        ];
        $linkreferral = 'https://linkexample.com/referral';
        $recentBonuses = [
            [
                'created_at' => now(),
                'badge_color' => 'blue',
                'type' => 'Direct Referral',
                'amount' => '1000000',
                'description' => 'Bonus rekrut langsung dari Budi Santoso',
            ],
        ];
    @endphp
    {{-- Display Stat Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        @foreach ($dataCards as $title => $value)
            <x-card.mini-card :value="$value" :title="$title" />
        @endforeach
    </div>
    {{-- Referral Link --}}
    <x-card.refferal-card :referralLink="$linkreferral" />
    {{-- Recent Bonuses Table --}}
    <x-card.mini-table-card :data="$recentBonuses" />
</x-layouts>
