<x-app-layout>
    <div class="max-w-4xl mx-auto p-4 md:p-8 bg-[#0f172a] rounded-[2.5rem] shadow-2xl border border-slate-800 mt-8 text-slate-200">
        {{-- Header avec Horloge --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-10 gap-6">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-blue-500/10 rounded-2xl border border-blue-500/20 shadow-[0_0_15px_rgba(59,130,246,0.2)]">
                    <i class="fa-solid fa-fingerprint text-3xl text-blue-400"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-black tracking-tight text-white italic uppercase">SMART <span class="text-blue-500">CHECK</span></h2>
                    <p class="text-[9px] font-bold text-slate-500 tracking-[0.3em] uppercase">Validation Biométrique & Horaire</p>
                </div>
            </div>
            <div class="flex flex-col items-end bg-slate-900/50 p-4 rounded-2xl border border-slate-800">
                <span id="date-jour" class="text-[10px] text-slate-400 font-black uppercase mb-1"></span>
                <span id="horloge" class="text-3xl font-mono text-blue-500 font-black tracking-tighter shadow-blue-500/20">00:00:00</span>
            </div>
        </div>

        {{-- Statut Géo --}}
        <div id="geo-status" class="mb-8 p-4 rounded-2xl bg-slate-900 border border-slate-800 text-[10px] font-black uppercase flex items-center gap-3 transition-all duration-500">
            <div class="w-2 h-2 rounded-full bg-slate-700"></div>
            <span>Initialisation du signal...</span>
        </div>

        {{-- Grid de Pointage --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            @php
                $steps = [
                    'check_in_8h30'   => ['label' => 'Arrivée', 'time' => '08:30'],
                    'check_out_12h00' => ['label' => 'Pause', 'time' => '12:00'],
                    'check_in_14h00'  => ['label' => 'Reprise', 'time' => '14:00'],
                    'check_out_17h00' => ['label' => 'Descente', 'time' => '17:00'],
                ];
                $prev = true;
            @endphp

            @foreach($steps as $id => $info)
                @php
                    $done = $attendance && $attendance->$id;
                    $active = !$done && $prev;
                    $prev = $done;
                @endphp
                <button id="btn-{{ $id }}" 
                    data-time="{{ $info['time'] }}"
                    onclick="submitPointage('{{ $id }}')"
                    {{ !$active ? 'disabled' : '' }}
                    class="btn-pointage relative p-6 rounded-[2rem] border transition-all duration-500 flex flex-col items-center gap-2
                    {{ $done ? 'bg-emerald-500/5 border-emerald-500/30 text-emerald-400' : ($active ? 'bg-slate-900 border-slate-700 text-slate-500 opacity-40 cursor-not-allowed' : 'bg-slate-950/50 border-slate-900 text-slate-800 cursor-not-allowed opacity-20') }}">
                    
                    <span class="text-[8px] font-black uppercase tracking-widest">{{ $info['label'] }}</span>
                    <span class="text-2xl font-black font-mono">{{ $done ? $attendance->$id->format('H:i') : $info['time'] }}</span>
                    <span class="status-label text-[8px] font-bold italic uppercase">{{ $done ? '✅ Terminé' : 'Verrouillé' }}</span>
                </button>
            @endforeach
        </div>
    </div>

    <script>
        let uLat, uLng;
        const TARGET = { lat: 5.365237, lon: -3.957816 };

        function updateClock() {
            const now = new Date();
            const timeStr = now.toLocaleTimeString('fr-FR', {hour12:false});
            document.getElementById('horloge').textContent = timeStr;
            document.getElementById('date-jour').textContent = now.toLocaleDateString('fr-FR', {weekday:'long', day:'numeric', month:'long'}).toUpperCase();
            
            // On vérifie l'heure pour débloquer les boutons en temps réel
            checkButtons(now);
        }

        function checkButtons(now) {
            const currentHM = now.getHours() * 60 + now.getMinutes();
            document.querySelectorAll('.btn-pointage:not([disabled])').forEach(btn => {
                const [h, m] = btn.dataset.time.split(':').map(Number);
                const targetHM = h * 60 + m;
                const isTimeOk = currentHM >= targetHM;
                const isInside = document.getElementById('geo-status').classList.contains('bg-emerald-500/10');

                if (isTimeOk && isInside) {
                    btn.classList.remove('opacity-40', 'cursor-not-allowed', 'text-slate-500');
                    btn.classList.add('border-blue-500', 'text-white', 'shadow-[0_0_20px_rgba(59,130,246,0.2)]');
                    btn.querySelector('.status-label').textContent = "👉 Cliquer ici";
                } else {
                    btn.classList.add('opacity-40', 'cursor-not-allowed');
                    btn.querySelector('.status-label').textContent = !isTimeOk ? `Attendre ${btn.dataset.time}` : "Zone requise";
                }
            });
        }

        if (navigator.geolocation) {
            navigator.geolocation.watchPosition(p => {
                uLat = p.coords.latitude; uLng = p.coords.longitude;
                const dist = calculateDistance(uLat, uLng, TARGET.lat, TARGET.lon);
                const ok = dist <= 150;
                const s = document.getElementById('geo-status');
                s.className = `mb-8 p-4 rounded-2xl border text-[10px] font-black uppercase flex items-center gap-3 transition-all ${ok ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400' : 'bg-red-500/10 border-red-500/20 text-red-400'}`;
                s.innerHTML = `<div class="w-2 h-2 rounded-full ${ok?'bg-emerald-500 animate-pulse':'bg-red-500'}"></div><span>${ok?'✅ Zone de travail':'❌ Hors zone'} (${Math.round(dist)}m)</span>`;
            });
        }

        function calculateDistance(la1, lo1, la2, lo2) {
            const R=6371e3, p=Math.PI/180, a=0.5-Math.cos((la2-la1)*p)/2+Math.cos(la1*p)*Math.cos(la2*p)*(1-Math.cos((lo2-lo1)*p))/2;
            return 2*R*Math.asin(Math.sqrt(a));
        }

        function submitPointage(step) {
            fetch("{{ route('attendances.store') }}", {
                method:'POST',
                headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{csrf_token()}}','Accept':'application/json'},
                body:JSON.stringify({step, lat:uLat, lng:uLng})
            }).then(async r => {
                const d = await r.json();
                alert(d.message || d.error);
                if(r.ok) location.reload();
            });
        }

        setInterval(updateClock, 1000);
        updateClock();
    </script>
</x-app-layout>