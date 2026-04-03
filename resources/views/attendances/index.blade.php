<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

    <div class="max-w-4xl mx-auto p-4 md:p-8 bg-[#0f172a] rounded-[2rem] md:rounded-[2.5rem] shadow-2xl border border-slate-800 mt-4 md:mt-8 text-slate-200">
        
        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 md:mb-10 gap-6">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-blue-500/10 rounded-2xl border border-blue-500/20 shadow-[0_0_15px_rgba(59,130,246,0.2)]">
                    <i class="fa-solid fa-fingerprint text-2xl md:text-3xl text-blue-400"></i>
                </div>
                <div>
                    <h2 class="text-xl md:text-2xl font-black tracking-tight text-white italic uppercase">SMART <span class="text-blue-500">CHECK</span></h2>
                    <p class="text-[8px] md:text-[9px] font-bold text-slate-500 tracking-[0.3em] uppercase">Validation Biométrique & Horaire</p>
                </div>
            </div>
            <div class="flex flex-row md:flex-col justify-between items-center md:items-end bg-slate-900/50 p-4 rounded-2xl border border-slate-800">
                <span id="date-jour" class="text-[9px] md:text-[10px] text-slate-400 font-black uppercase md:mb-1"></span>
                <span id="horloge" class="text-2xl md:text-3xl font-mono text-blue-500 font-black tracking-tighter shadow-blue-500/20">00:00:00</span>
            </div>
        </div>

        {{-- Score Assiduité --}}
        @php
            $isWeekend = \Carbon\Carbon::now()->isWeekend();
            $now = \Carbon\Carbon::now();
            $quota = 3;
            $statusColor = $daysPresentCount >= $quota ? 'emerald' : ($daysPresentCount > 0 ? 'blue' : 'slate');
        @endphp

        <div class="mb-6 md:mb-8 p-5 md:p-6 rounded-[1.5rem] md:rounded-[2rem] bg-slate-900/30 border border-slate-800 shadow-inner">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4 sm:mb-4">
                <div>
                    <h3 class="text-[9px] md:text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-1">Score Hebdomadaire</h3>
                    <p class="text-lg md:text-xl font-black text-white italic">{{ $daysPresentCount }}/{{ $quota }} <span class="text-xs md:text-sm text-slate-500 uppercase">Jours valides</span></p>
                </div>
                <div class="text-right w-full sm:w-auto">
                    <span class="text-[8px] md:text-[9px] font-bold px-3 py-1 rounded-full border border-{{ $statusColor }}-500/30 text-{{ $statusColor }}-400 bg-{{ $statusColor }}-500/5 block sm:inline-block text-center">
                        {{ $daysPresentCount >= $quota ? 'OBJECTIF ATTEINT 🏆' : 'EN PROGRESSION' }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Statut Géo --}}
        @if(!$isWeekend)
            <div id="geo-status" class="mb-6 md:mb-8 p-4 rounded-xl md:rounded-2xl bg-slate-900 border border-slate-800 text-[9px] md:text-[10px] font-black uppercase flex items-center gap-3 transition-all duration-500">
                <div class="w-2 h-2 rounded-full bg-slate-700"></div>
                <span>Initialisation du signal GPS...</span>
            </div>
        @endif

        {{-- Grid de Pointage --}}
        <div class="grid grid-cols-1 xs:grid-cols-2 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            @php
                $steps = [
                    'check_in_8h30'   => ['label' => 'Arrivée', 'time' => '08:30', 'h' => 8, 'm' => 0],
                    'check_out_12h00' => ['label' => 'Pause',   'time' => '12:00', 'h' => 12, 'm' => 0],
                    'check_in_14h00'  => ['label' => 'Reprise', 'time' => '14:00', 'h' => 14, 'm' => 0],
                    'check_out_17h00' => ['label' => 'Descente','time' => '17:00', 'h' => 17, 'm' => 0],
                ];
                $prevDone = true; 
            @endphp

            @foreach($steps as $id => $info)
                @php
                    $done = $attendance && $attendance->$id;
                    $timeReached = $now->hour >= $info['h'];
                    $active = !$done && $timeReached && $prevDone && !$isWeekend;
                    $prevDone = $done;
                @endphp
                
                <button id="btn-{{ $id }}" 
                    onclick="submitPointage('{{ $id }}')"
                    {{ !$active ? 'disabled' : '' }}
                    class="btn-pointage relative p-5 md:p-6 rounded-[1.5rem] md:rounded-[2rem] border transition-all duration-500 flex flex-col items-center gap-2
                    {{ $done 
                        ? 'bg-emerald-500/5 border-emerald-500/30 text-emerald-400' 
                        : ($active 
                            ? 'bg-slate-900 border-blue-500/50 text-blue-400 shadow-[0_0_15px_rgba(59,130,246,0.1)]' 
                            : 'bg-slate-950/50 border-slate-900 text-slate-800 opacity-20') }}">
                    
                    <span class="text-[7px] md:text-[8px] font-black uppercase tracking-widest">{{ $info['label'] }}</span>
                    <span class="text-xl md:text-2xl font-black font-mono">{{ $done ? \Carbon\Carbon::parse($attendance->$id)->format('H:i') : $info['time'] }}</span>
                    
                    <span class="status-label text-[7px] md:text-[8px] font-bold italic uppercase">
                        @if($done) ✅ Validé 
                        @elseif($active) ⚡ Cliquer 
                        @elseif(!$timeReached) ⏳ Attendre
                        @else 🔒 Verrouillé 
                        @endif
                    </span>
                </button>
            @endforeach
        </div>

        {{-- NOUVEAU : BLOC PLANNING --}}
        <div class="p-6 md:p-8 rounded-[2rem] bg-slate-900/50 border border-slate-800">
            <div class="flex items-center gap-3 mb-6">
                <i class="fa-solid fa-calendar-check text-blue-500 text-lg"></i>
                <div>
                    <h3 class="text-[10px] font-black text-white uppercase tracking-widest">Planning de présence</h3>
                    <p class="text-[8px] font-bold text-slate-500 uppercase">Sélectionnez vos 3 jours obligatoires</p>
                </div>
            </div>
            
            <form action="{{ route('attendances.updateAvailability') }}" method="POST">
                @csrf
                <div class="grid grid-cols-5 gap-2 md:gap-4 mb-6">
                    @php 
                        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'];
                        $selectedDays = $myAvailability ? $myAvailability->days : [];
                    @endphp
                    @foreach($jours as $j)
                        <label class="group cursor-pointer">
                            <input type="checkbox" name="days[]" value="{{ $j }}" class="hidden peer" {{ in_array($j, $selectedDays) ? 'checked' : '' }}>
                            <div class="py-4 rounded-2xl border border-slate-800 bg-slate-950 flex flex-col items-center gap-1 transition-all group-hover:border-slate-700 peer-checked:border-blue-500 peer-checked:bg-blue-500/10">
                                <span class="text-[9px] font-black uppercase text-slate-500 peer-checked:text-blue-400">{{ substr($j, 0, 3) }}</span>
                                <div class="w-1.5 h-1.5 rounded-full bg-slate-800 peer-checked:bg-blue-500"></div>
                            </div>
                        </label>
                    @endforeach
                </div>
                <button type="submit" class="w-full py-4 bg-blue-600 hover:bg-blue-500 text-white text-[10px] font-black uppercase rounded-2xl transition-all shadow-lg shadow-blue-900/20">
                    Enregistrer mes disponibilités
                </button>
            </form>
        </div>
    </div>

    <script>
        let uLat, uLng;
        const TARGET = { lat: 5.365237, lon: -3.957816 };
        
        if({{ $daysPresentCount >= 3 ? 'true' : 'false' }}) {
            confetti({ particleCount: 150, spread: 70, origin: { y: 0.6 }, colors: ['#10b981', '#3b82f6'] });
        }

        function updateClock() {
            const now = new Date();
            const clockEl = document.getElementById('horloge');
            const dateEl = document.getElementById('date-jour');
            if(clockEl) clockEl.textContent = now.toLocaleTimeString('fr-FR', {hour12:false});
            if(dateEl) dateEl.textContent = now.toLocaleDateString('fr-FR', {weekday:'long', day:'numeric', month:'long'}).toUpperCase();
        }

        if (navigator.geolocation) {
            navigator.geolocation.watchPosition(p => {
                uLat = p.coords.latitude; uLng = p.coords.longitude;
                const dist = calculateDistance(uLat, uLng, TARGET.lat, TARGET.lon);
                const ok = dist <= 150;
                const s = document.getElementById('geo-status');
                if(s) {
                    s.className = `mb-8 p-4 rounded-2xl border text-[9px] md:text-[10px] font-black uppercase flex items-center gap-3 transition-all ${ok ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400' : 'bg-red-500/10 border-red-500/20 text-red-400'}`;
                    s.innerHTML = `<div class="w-2 h-2 rounded-full ${ok?'bg-emerald-500 animate-pulse':'bg-red-500'}"></div><span>${ok?'✅ Zone de travail':'❌ Hors zone'} (${Math.round(dist)}m)</span>`;
                }
            }, null, {enableHighAccuracy:true});
        }

        function calculateDistance(la1, lo1, la2, lo2) {
            const R=6371e3, p=Math.PI/180, a=0.5-Math.cos((la2-la1)*p)/2+Math.cos(la1*p)*Math.cos(la2*p)*(1-Math.cos((lo2-lo1)*p))/2;
            return 2*R*Math.asin(Math.sqrt(a));
        }

        function submitPointage(step) {
            if(!uLat || !uLng) return alert("Attente du signal GPS...");
            
            fetch("{{ route('attendances.store') }}", {
                method:'POST',
                headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{csrf_token()}}','Accept':'application/json'},
                body:JSON.stringify({step, lat:uLat, lng:uLng})
            }).then(async r => {
                const d = await r.json();
                if(r.ok) location.reload(); else alert(d.message);
            });
        }
        setInterval(updateClock, 1000); updateClock();
    </script>
</x-app-layout>