<x-app-layout>

    <script src="https://cdn.tailwindcss.com"></script>
    <div class="container mx-auto px-2 py-4">
        <div class="max-w-4xl mx-auto">
            <!-- En-tête -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                 <h1 class="text-3xl font-bold text-gray-800 mb-4">
                        Dépenses de {{ $user->name }}
                    </h1>
                <div class="grid grid-cols-3 gap-4">
                    <div class="bg-blue-50 rounded-lg p-4">
                        <p class="text-sm text-blue-600">Total des dépenses</p>
                        <p class="text-2xl font-bold text-blue-700">
                            {{ number_format($dailyTotals->sum(), 2) }} Fc
                        </p>
                    </div>
                    <div class="bg-green-50 rounded-lg p-4">
                        <p class="text-sm text-green-600">Moyenne par jour</p>
                        <p class="text-2xl font-bold text-green-700">
                            {{ number_format($dailyTotals->average(), 2) }} Fc
                        </p>
                    </div>
                    <div class="bg-purple-50 rounded-lg p-4">
                        <p class="text-sm text-purple-600">Nombre de transactions</p>
                        <p class="text-2xl font-bold text-purple-700">
                            @if(isset($depensesGrouped) && $depensesGrouped->isNotEmpty())
                                {{ $depensesGrouped->flatten()->count() }}
                            @else
                                0
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Liste des dépenses par jour -->
            @foreach($depensesGrouped as $date => $dailyDepenses)
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">
                        {{ \Carbon\Carbon::parse($date)->format('d M Y') }}
                    </h2>
                    <div class="bg-gray-100 px-4 py-2 rounded-full">
                        <span class="text-gray-700 font-medium">
                            Total: {{ number_format($dailyTotals[$date], 2) }} Fc
                        </span>
                    </div>
                </div>

                <div class="space-y-4">
                    @foreach($dailyDepenses as $depense)
                    <div class="flex items-center justify-between p-4 hover:bg-gray-50 rounded-lg transition-colors">
                        <div class="flex items-center space-x-4">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center
                                      {{ $depense->categorie->name === 'Alimentation' ? 'bg-green-100 text-green-600' :
                                         ($depense->categorie->name === 'Transport' ? 'bg-blue-100 text-blue-600' :
                                         'bg-purple-100 text-purple-600') }}">
                                <i class="fas fa-{{ $depense->categorie->name === 'Alimentation' ? 'utensils' :
                                                  ($depense->categorie->name === 'Transport' ? 'car' : 'shopping-bag') }}"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">{{ $depense->description }}</p>
                                <p class="text-sm text-gray-500">{{ $depense->categorie->name }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-gray-800">{{ number_format($depense->montant, 2) }} Fc</p>
                            <p class="text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($depense->date)->format('H:i') }}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
</body>
</html>
</x-app-layout>
