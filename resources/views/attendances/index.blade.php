<x-app-layout>
    <div class="max-w-4xl mx-auto p-4 md:p-8 bg-[#0f172a] rounded-[2.5rem] shadow-2xl border border-slate-800 mt-8 text-slate-200">
        
        {{-- Header avec Horloge Néon --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-10 gap-6">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-blue-500/10 rounded-2xl border border-blue-500/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <rect width="18" height="18" x="3" y="4" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-black tracking-tight text-white italic uppercase">POINTAG<span class="text-blue-500">E</span></h2>
                    <p class="text-xs font-bold text-slate-500 tracking-[0.2em] uppercase">Empreinte</p>
                </div>
            </div>
            
            <div class="flex flex-col items-end bg-slate-900/50 p-4 rounded-2xl border border-slate-800">
                <span id="date-jour" class="text-xs text-slate-400 font-bold uppercase tracking-widest mb-1"></span>
                <span id="horloge" class="text-3xl font-mono text-blue-500 font-black drop-shadow-[0_0_10px_rgba(59,130,246,0.5)]"></span>
            </div>
        </div>

        {{-- Progress Bar Dark --}}
        <div class="mb-10 bg-slate-900/80 p-6 rounded-[2rem] border border-slate-800 shadow-inner">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em]">Performance Hebdo</h3>
                <span class="px-3 py-1 rounded-full text-xs font-black {{ $completedDaysCount >= 3 ? 'bg-emerald-500/10 text-emerald-400' : 'bg-blue-500/10 text-blue-400' }}">
                    {{ $completedDaysCount }} / 3 JOURS
                </span>
            </div>
            <div class="w-full bg-slate-800 rounded-full h-3 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-500 h-full rounded-full transition-all duration-1000 shadow-[0_0_15px_rgba(59,130,246,0.4)]" 
                     style="width: {{ min(($completedDaysCount / 3) * 100, 100) }}%"></div>
            </div>
        </div>

        {{-- Geo Status Floating Card --}}
        <div id="geo-status" class="mb-8 p-4 rounded-2xl bg-slate-900 border border-slate-800 text-sm flex items-center gap-3 transition-all duration-500">
            <div class="animate-pulse w-2 h-2 rounded-full bg-yellow-500 shadow-[0_0_8px_rgba(234,179,8,0.6)]"></div>
            <span class="text-slate-400 font-medium">Initialisation GPS...</span>
        </div>

        {{-- Grid de Pointage --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            @php
                $steps = [
                    'check_in_8h30'   => ['label' => 'Arrivée Matin', 'icon' => 'M9 12l2 2 4-4', 'color' => 'blue'],
                    'check_out_12h00' => ['label' => 'Pause Déjeuner', 'icon' => 'M12 3v9l9 9', 'color' => 'amber'],
                    'check_in_14h00'  => ['label' => 'Retour Travail', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'color' => 'purple'],
                    'check_out_17h00' => ['label' => 'Départ Soir', 'icon' => 'M17 16l4-4m0 0l-4-4m4 4H7', 'color' => 'emerald'],
                ];
                $previousStepValue = true; 
            @endphp

            @foreach($steps as $key => $info)
                @php
                    $isRecorded = ($attendance && $attendance->$key);
                    $canClick = !$isRecorded && $previousStepValue;
                    $previousStepValue = $isRecorded;
                @endphp

                <button id="btn-{{ $loop->iteration }}" 
                    onclick="submitPointage('{{ $key }}')"
                    {{ !$canClick ? 'disabled' : '' }}
                    class="relative group p-6 rounded-[2rem] transition-all duration-300 border flex flex-col items-center justify-center gap-3
                    {{ $isRecorded 
                        ? 'bg-slate-800/40 border-emerald-500/30 text-emerald-400 shadow-[0_0_20px_rgba(16,185,129,0.05)]' 
                        : ($canClick 
                            ? 'bg-slate-900 border-slate-700 text-slate-300 hover:border-blue-500/50 hover:bg-slate-800 active:scale-95 cursor-pointer' 
                            : 'bg-slate-950/50 border-slate-900 text-slate-700 cursor-not-allowed opacity-40') 
                    }}">
                    
                    <span class="text-[9px] font-black uppercase tracking-[0.2em] {{ $isRecorded ? 'text-emerald-500/60' : 'text-slate-500' }}">
                        {{ $info['label'] }}
                    </span>

                    <div class="text-2xl font-black font-mono">
                        @if($isRecorded)
                            {{ \Carbon\Carbon::parse($attendance->$key)->format('H:i') }}
                        @else
                            <span class="opacity-30">{{ str_replace(['check_in_', 'check_out_', 'h'], ['', '', ':'], $key) }}</span>
                        @endif
                    </div>

                    @if($isRecorded)
                        <div class="px-3 py-1 rounded-full bg-emerald-500/10 text-[9px] font-black uppercase tracking-tighter">✅ Validé</div>
                    @elseif($canClick)
                        <div class="px-3 py-1 rounded-full bg-blue-500/10 text-blue-400 text-[9px] font-black uppercase tracking-tighter animate-pulse">Prêt</div>
                    @else
                        <div class="text-[9px] font-black uppercase opacity-20 italic">Bloqué</div>
                    @endif
                </button>
            @endforeach
        </div>
    </div>

    <script>
        function updateDateTime() {
            const now = new Date();
            const jours = ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'];
            const mois = ['JANVIER','FÉVRIER','MARS','AVRIL','MAI','JUIN','JUILLET','AOÛT','SEPTEMBRE','OCTOBRE','NOVEMBRE','DÉCEMBRE'];
            document.getElementById('date-jour').textContent = `${jours[now.getDay()]} ${now.getDate()} ${mois[now.getMonth()]}`;
            document.getElementById('horloge').textContent = now.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        }
        setInterval(updateDateTime, 1000);
        updateDateTime();

        const PHARMACIE_LAT = 5.365237;
        const PHARMACIE_LON = -3.957816;

        function checkLocation() {
            if (!navigator.geolocation) {
                updateGeoStatus("❌ GPS non supporté", "red");
                return;
            }
            navigator.geolocation.getCurrentPosition((position) => {
                const distance = calculateDistance(position.coords.latitude, position.coords.longitude, PHARMACIE_LAT, PHARMACIE_LON);
                if(distance <= 100) {
                    updateGeoStatus(`✅ ZONE ATTEINTE (${Math.round(distance)}m) - POINTAGE DÉVERROUILLÉ`, "green");
                } else {
                    updateGeoStatus(`❌ HORS ZONE (${Math.round(distance)}m) - RAPPROCHEZ-VOUS`, "red");
                }
            }, (error) => {
                updateGeoStatus("⚠️ ACCÈS GPS REQUIS", "yellow");
            });
        }

        function updateGeoStatus(text, color) {
            const el = document.getElementById('geo-status');
            const dot = el.querySelector('div');
            el.querySelector('span').textContent = text;
            
            if(color === "green") {
                el.className = "mb-8 p-4 rounded-2xl bg-emerald-500/5 border border-emerald-500/20 text-emerald-400 text-sm flex items-center gap-3";
                dot.className = "w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.6)]";
            } else if(color === "red") {
                el.className = "mb-8 p-4 rounded-2xl bg-red-500/5 border border-red-500/20 text-red-400 text-sm flex items-center gap-3";
                dot.className = "w-2 h-2 rounded-full bg-red-500 shadow-[0_0_8px_rgba(239,68,68,0.6)]";
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

        window.onload = function() {
            checkLocation();
            updateDateTime();
        };

        function submitPointage(step) {
            fetch("{{ route('attendances.store') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ step: step })
            })
            .then(response => response.ok ? window.location.reload() : alert("Erreur réseau"))
            .catch(error => console.error('Erreur:', error));
        }
    </script>
</x-app-layout>