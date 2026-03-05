<x-app-layout>
    <div class="max-w-4xl mx-auto p-4 md:p-8 bg-[#0f172a] rounded-[2.5rem] shadow-2xl border border-slate-800 mt-8 text-slate-200">
        
        {{-- Header avec Horloge --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-10 gap-6">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-blue-500/10 rounded-2xl border border-blue-500/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <rect width="18" height="18" x="3" y="4" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-black tracking-tight text-white italic uppercase">POINTAG<span class="text-blue-500">E</span></h2>
                    <p class="text-xs font-bold text-slate-500 tracking-[0.2em] uppercase">Temps Réel & Géo-sécurisé</p>
                </div>
            </div>
            
            <div class="flex flex-col items-end bg-slate-900/50 p-4 rounded-2xl border border-slate-800">
                <span id="date-jour" class="text-xs text-slate-400 font-bold uppercase tracking-widest mb-1"></span>
                <span id="horloge" class="text-3xl font-mono text-blue-500 font-black drop-shadow-[0_0_10px_rgba(59,130,246,0.5)]"></span>
            </div>
        </div>

        {{-- Geo Status --}}
        <div id="geo-status" class="mb-8 p-4 rounded-2xl bg-slate-900 border border-slate-800 text-sm flex items-center gap-3 transition-all duration-500">
            <div class="animate-pulse w-2 h-2 rounded-full bg-yellow-500 shadow-[0_0_8px_rgba(234,179,8,0.6)]"></div>
            <span class="text-slate-400 font-medium italic">Analyse de votre position GPS...</span>
        </div>

        {{-- Grid de Pointage --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            @php
                $steps = [
                    'check_in_8h30'   => ['label' => 'Arrivée Matin', 'target' => '08:30'],
                    'check_out_12h00' => ['label' => 'Pause Déjeuner', 'target' => '12:00'],
                    'check_in_14h00'  => ['label' => 'Retour Travail', 'target' => '14:00'],
                    'check_out_17h00' => ['label' => 'Départ Soir', 'target' => '17:00'],
                ];
                $previousStepValue = true; 
            @endphp

            @foreach($steps as $key => $info)
                @php
                    $isRecorded = ($attendance && $attendance->$key);
                    $canClick = !$isRecorded && $previousStepValue;
                    $previousStepValue = $isRecorded;
                @endphp

                <button id="btn-{{ $key }}" 
                    onclick="submitPointage('{{ $key }}')"
                    {{ !$canClick ? 'disabled' : '' }}
                    class="btn-pointage relative group p-6 rounded-[2rem] transition-all duration-300 border flex flex-col items-center justify-center gap-3
                    {{ $isRecorded ? 'bg-slate-800/40 border-emerald-500/30 text-emerald-400' : ($canClick ? 'bg-slate-900 border-slate-700 text-slate-300 hover:scale-105 opacity-50 pointer-events-none' : 'bg-slate-950/50 border-slate-900 text-slate-700 cursor-not-allowed opacity-40') }}">
                    
                    <span class="text-[9px] font-black uppercase tracking-[0.2em]">{{ $info['label'] }}</span>
                    <div class="text-2xl font-black font-mono">
                        {{ $isRecorded ? $attendance->$key->format('H:i') : $info['target'] }}
                    </div>
                    
                    @if($isRecorded)
                        <div class="text-[9px] font-black uppercase text-emerald-500/60">✅ Validé</div>
                    @elseif($canClick)
                        <div class="status-text text-[9px] font-black uppercase text-orange-500">Attente Zone</div>
                    @endif
                </button>
            @endforeach
        </div>
    </div>

    <script>
        let userLat = null;
        let userLng = null;
        const PHARMACIE_LAT = 5.365237;
        const PHARMACIE_LON = -3.957816;

        function updateDateTime() {
            const now = new Date();
            document.getElementById('horloge').textContent = now.toLocaleTimeString('fr-FR');
            document.getElementById('date-jour').textContent = now.toLocaleDateString('fr-FR', { weekday: 'long', day: 'numeric', month: 'long' }).toUpperCase();
        }
        setInterval(updateDateTime, 1000);

        // Surveillance GPS en temps réel
        if (navigator.geolocation) {
            navigator.geolocation.watchPosition((position) => {
                userLat = position.coords.latitude;
                userLng = position.coords.longitude;
                
                const distance = calculateDistance(userLat, userLng, PHARMACIE_LAT, PHARMACIE_LON);
                const isInside = distance <= 150; // 150 mètres

                updateGeoUI(isInside, distance);
            }, (error) => {
                updateGeoStatus("⚠️ ACTIVEZ VOTRE GPS POUR POINTER", "red");
            }, { enableHighAccuracy: true });
        }

        function updateGeoUI(isInside, distance) {
            const statusBox = document.getElementById('geo-status');
            const buttons = document.querySelectorAll('.btn-pointage:not([disabled])');
            
            if (isInside) {
                statusBox.className = "mb-8 p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm flex items-center gap-3";
                statusBox.innerHTML = `<div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div><span>✅ ZONE ATTEINTE (${Math.round(distance)}m)</span>`;
                
                buttons.forEach(btn => {
                    btn.classList.remove('opacity-50', 'pointer-events-none');
                    btn.classList.add('border-blue-500', 'shadow-[0_0_15px_rgba(59,130,246,0.3)]');
                    if(btn.querySelector('.status-text')) btn.querySelector('.status-text').textContent = "PRÊT";
                });
            } else {
                statusBox.className = "mb-8 p-4 rounded-2xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm flex items-center gap-3";
                statusBox.innerHTML = `<div class="w-2 h-2 rounded-full bg-red-500"></div><span>❌ HORS ZONE (${Math.round(distance)}m)</span>`;
                
                buttons.forEach(btn => {
                    btn.classList.add('opacity-50', 'pointer-events-none');
                    if(btn.querySelector('.status-text')) btn.querySelector('.status-text').textContent = "ZONE REQUISE";
                });
            }
        }

        function calculateDistance(lat1, lon1, lat2, lon2) {
            const R = 6371e3;
            const φ1 = lat1 * Math.PI/180;
            const φ2 = lat2 * Math.PI/180;
            const Δφ = (lat2-lat1) * Math.PI/180;
            const Δλ = (lon2-lon1) * Math.PI/180;
            const a = Math.sin(Δφ/2) * Math.sin(Δφ/2) + Math.cos(φ1) * Math.cos(φ2) * Math.sin(Δλ/2) * Math.sin(Δλ/2);
            return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        }

        function submitPointage(step) {
            fetch("{{ route('attendances.store') }}", {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                body: JSON.stringify({ step: step, lat: userLat, lng: userLng })
            })
            .then(async res => {
                const data = await res.json();
                alert(data.message || data.error);
                if(res.ok) window.location.reload();
            });
        }
    </script>
</x-app-layout>