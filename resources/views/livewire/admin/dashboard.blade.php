<div class="w-full min-h-screen px-0 py-8 overflow-x-hidden bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900" style="margin: 0; max-width: 100vw;">
  <!-- Header -->
  <div class="max-w-full px-8 mb-12">
    <h1 class="mb-2 text-4xl font-bold text-white">Dashboard Administratif</h1>
    <p class="text-lg text-slate-400">Vue d'ensemble de votre établissement</p>
  </div>

  <!-- KPI Cards -->
  <div class="grid grid-cols-1 gap-6 px-8 mb-8 md:grid-cols-2 lg:grid-cols-4">
    <!-- Total Étudiants -->
    <div class="relative p-6 overflow-hidden transition-all duration-300 cursor-pointer group bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl hover:shadow-2xl">
      <div class="absolute inset-0 transition-opacity bg-white opacity-0 group-hover:opacity-5"></div>
      <div class="relative z-10">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-sm font-semibold text-blue-100">Total Étudiants</h3>
          <svg class="w-8 h-8 text-blue-300" fill="currentColor" viewBox="0 0 20 20">
            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
          </svg>
        </div>
        <div class="mb-1 text-3xl font-bold text-white" wire:key="total-students">{{ $totalStudents }}</div>
        <p class="text-xs text-blue-100">{{ $studentsThisYear }} cette année</p>
      </div>
    </div>

    <!-- Inscriptions Validées -->
    <div class="relative p-6 overflow-hidden transition-all duration-300 cursor-pointer group bg-gradient-to-br from-green-600 to-green-700 rounded-2xl hover:shadow-2xl">
      <div class="absolute inset-0 transition-opacity bg-white opacity-0 group-hover:opacity-5"></div>
      <div class="relative z-10">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-sm font-semibold text-green-100">Inscriptions Validées</h3>
          <svg class="w-8 h-8 text-green-300" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
          </svg>
        </div>
        <div class="mb-1 text-3xl font-bold text-white" wire:key="enrollments-validated">{{ $enrollmentsValidated }}</div>
        <p class="text-xs text-green-100">✓ Confirmées</p>
      </div>
    </div>

    <!-- Collecte Financière -->
    <div class="relative p-6 overflow-hidden transition-all duration-300 cursor-pointer group bg-gradient-to-br from-purple-600 to-purple-700 rounded-2xl hover:shadow-2xl">
      <div class="absolute inset-0 transition-opacity bg-white opacity-0 group-hover:opacity-5"></div>
      <div class="relative z-10">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-sm font-semibold text-purple-100">Collecté</h3>
          <svg class="w-8 h-8 text-purple-300" fill="currentColor" viewBox="0 0 20 20">
            <path d="M8.16 2.75a.75.75 0 00-.328 1.464c3.783 1.899 6.368 5.776 6.368 10.286A6.75 6.75 0 1110.75 3.75a.75.75 0 000-1.5A8.25 8.25 0 102 10a.75.75 0 001.5 0c0-3.51 2.585-6.387 6.16-8.25z"></path>
          </svg>
        </div>
        <div class="mb-1 text-3xl font-bold text-white" wire:key="total-collected">{{ number_format($totalCollected, 0, ',', ' ') }} FCFA</div>
        <div class="flex items-center justify-between">
          <p class="text-xs text-purple-100">{{ $collectionRate }}% collecté</p>
          <div class="w-16 h-2 overflow-hidden bg-purple-400 rounded-full">
            <div class="h-full bg-white" style="width: {{ min($collectionRate, 100) }}%"></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Montant Restant -->
    <div class="relative p-6 overflow-hidden transition-all duration-300 cursor-pointer group bg-gradient-to-br from-orange-600 to-orange-700 rounded-2xl hover:shadow-2xl">
      <div class="absolute inset-0 transition-opacity bg-white opacity-0 group-hover:opacity-5"></div>
      <div class="relative z-10">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-sm font-semibold text-orange-100">À Collecter</h3>
          <svg class="w-8 h-8 text-orange-300" fill="currentColor" viewBox="0 0 20 20">
            <path d="M8.5 10.5A1.5 1.5 0 1110 9a1.5 1.5 0 01-1.5 1.5z"></path>
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a3 3 0 116 0 3 3 0 01-6 0z" clip-rule="evenodd"></path>
          </svg>
        </div>
        <div class="mb-1 text-3xl font-bold text-white" wire:key="total-remaining">{{ number_format($totalRemaining, 0, ',', ' ') }} FCFA</div>
        <p class="text-xs text-orange-100">À recouvrer</p>
      </div>
    </div>
  </div>

  <!-- Charts Section -->
  <div class="grid grid-cols-1 gap-8 px-8 mb-8 lg:grid-cols-2">
    <!-- Inscriptions par Mois -->
    <div class="p-6 transition-colors border bg-slate-800/50 backdrop-blur border-slate-700/50 rounded-2xl hover:border-slate-600">
      <div class="flex items-center justify-between mb-6">
        <div>
          <h2 class="text-xl font-bold text-white">Inscriptions par Mois</h2>
          <p class="mt-1 text-sm text-slate-400">Tendance annuelle</p>
        </div>
        <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-blue-600/20">
          <svg class="w-6 h-6 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
            <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path>
          </svg>
        </div>
      </div>
      <canvas id="enrollmentChart"></canvas>
    </div>

    <!-- Paiements par Mois -->
    <div class="p-6 transition-colors border bg-slate-800/50 backdrop-blur border-slate-700/50 rounded-2xl hover:border-slate-600">
      <div class="flex items-center justify-between mb-6">
        <div>
          <h2 class="text-xl font-bold text-white">Paiements par Mois</h2>
          <p class="mt-1 text-sm text-slate-400">Montants collectés</p>
        </div>
        <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-green-600/20">
          <svg class="w-6 h-6 text-green-400" fill="currentColor" viewBox="0 0 20 20">
            <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path>
          </svg>
        </div>
      </div>
      <canvas id="paymentChart"></canvas>
    </div>

    <!-- Distribution par Programme -->
    <div class="p-6 transition-colors border bg-slate-800/50 backdrop-blur border-slate-700/50 rounded-2xl hover:border-slate-600">
      <div class="flex items-center justify-between mb-6">
        <div>
          <h2 class="text-xl font-bold text-white">Distribution par Programme</h2>
          <p class="mt-1 text-sm text-slate-400">Répartition des étudiants</p>
        </div>
        <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-purple-600/20">
          <svg class="w-6 h-6 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
            <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
            <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
          </svg>
        </div>
      </div>
      <canvas id="programChart"></canvas>
    </div>

    <!-- État des Paiements -->
    <div class="p-6 transition-colors border bg-slate-800/50 backdrop-blur border-slate-700/50 rounded-2xl hover:border-slate-600">
      <div class="flex items-center justify-between mb-6">
        <div>
          <h2 class="text-xl font-bold text-white">État Financier</h2>
          <p class="mt-1 text-sm text-slate-400">Vue résumée</p>
        </div>
        <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-orange-600/20">
          <svg class="w-6 h-6 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v2h16V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a2 2 0 002 2h8a2 2 0 002-2H6zm0 8a2 2 0 002 2h8a2 2 0 002-2H6z" clip-rule="evenodd"></path>
          </svg>
        </div>
      </div>
      <canvas id="financialChart"></canvas>
    </div>
  </div>

  <!-- Alerts Section -->
  <div class="grid grid-cols-1 gap-8 px-8 lg:grid-cols-2">
    <!-- Paiements en Retard -->
    <div class="p-6 transition-colors border bg-slate-800/50 backdrop-blur border-slate-700/50 rounded-2xl hover:border-red-600/30">
      <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
          <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-red-600/20">
            <svg class="w-6 h-6 text-red-400" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0zM8 9a1 1 0 100-2 1 1 0 000 2zm5-1a1 1 0 11-2 0 1 1 0 012 0zM14 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
            </svg>
          </div>
          <h3 class="text-lg font-bold text-white">Paiements en Retard</h3>
        </div>
        <span class="px-3 py-1 text-sm font-semibold text-red-300 rounded-full bg-red-600/20" wire:key="late-count">{{ count($studentsLatePayments) }}</span>
      </div>
      <div class="space-y-3 overflow-y-auto max-h-64">
        @forelse($studentsLatePayments as $student)
          <div class="p-3 transition-colors border rounded-lg bg-slate-700/50 border-red-600/20 hover:border-red-600/50">
            <p class="text-sm font-medium text-white">{{ $student->nom ?? 'Nom indisponible' }} {{ $student->prenom ?? 'Prénom indisponible' }}</p>
            <p class="mt-1 text-xs text-red-300">⚠️ Paiement en retard</p>
          </div>
        @empty
          <div class="py-8 text-sm text-center text-slate-400">✓ Aucun paiement en retard</div>
        @endforelse
      </div>
    </div>

    <!-- Inscriptions Attente de Paiement -->
    <div class="p-6 transition-colors border bg-slate-800/50 backdrop-blur border-slate-700/50 rounded-2xl hover:border-yellow-600/30">
      <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
          <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-yellow-600/20">
            <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-2.77 3.066 3.066 0 00-3.58 3.03A3.066 3.066 0 006.267 3.455zm9.8 6.778a3.066 3.066 0 001.746-2.77 3.066 3.066 0 00-3.579 3.03 3.066 3.066 0 001.833-.26zm7.436 7.324a3.066 3.066 0 001.746-2.77c0-2.033-2.692-3.66-3.58-3.03a3.066 3.066 0 001.834.26zm-2.866 2.25a2.066 2.066 0 10-2.066 2.066 2.066 2.066 0 002.066-2.066zm-6.5 0a2.066 2.066 0 10-2.066 2.066 2.066 2.066 0 002.066-2.066zm-6.5 0a2.066 2.066 0 10-2.066 2.066 2.066 2.066 0 002.066-2.066z" clip-rule="evenodd"></path>
            </svg>
          </div>
          <h3 class="text-lg font-bold text-white">En Attente de Paiement</h3>
        </div>
        <span class="px-3 py-1 text-sm font-semibold text-yellow-300 rounded-full bg-yellow-600/20" wire:key="pending-count">{{ count($enrollmentsPendingPayment) }}</span>
      </div>
      <div class="space-y-3 overflow-y-auto max-h-64">
        @forelse($enrollmentsPendingPayment as $enrollment)
          <div class="p-3 transition-colors border rounded-lg bg-slate-700/50 border-yellow-600/20 hover:border-yellow-600/50">
            <p class="text-sm font-medium text-white">{{ $enrollment->student->nom ?? 'Étudiant' }} {{ $enrollment->student->prenom ?? 'Étudiant' }}</p>
            <p class="mt-1 text-xs text-yellow-300">⏳ En cours de paiement</p>
          </div>
        @empty
          <div class="py-8 text-sm text-center text-slate-400">✓ Aucune inscription en attente</div>
        @endforelse
      </div>
    </div>
  </div>
</div>

<!-- Chart.js Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>

<script>
  // Configuration commune
  const chartOptions = {
    responsive: true,
    maintainAspectRatio: true,
    plugins: {
      legend: {
        labels: {
          color: '#cbd5e1',
          font: { size: 12, weight: '500' },
          usePointStyle: true,
        },
        display: true,
        position: 'bottom',
      },
      filler: {
        propagate: true,
      },
    },
    scales: {
      y: {
        grid: { color: '#334155', drawBorder: false },
        ticks: { color: '#94a3b8' },
      },
      x: {
        grid: { color: '#334155', drawBorder: false },
        ticks: { color: '#94a3b8' },
      },
    },
  };

  // Chart Inscriptions par Mois
  const enrollmentData = @json($enrollmentsByMonth);
  const enrollmentCtx = document.getElementById('enrollmentChart').getContext('2d');
  new Chart(enrollmentCtx, {
    type: 'line',
    data: {
      labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
      datasets: [{
        label: 'Inscriptions',
        data: [enrollmentData[1] || 0, enrollmentData[2] || 0, enrollmentData[3] || 0, enrollmentData[4] || 0, enrollmentData[5] || 0, enrollmentData[6] || 0, enrollmentData[7] || 0, enrollmentData[8] || 0, enrollmentData[9] || 0, enrollmentData[10] || 0, enrollmentData[11] || 0, enrollmentData[12] || 0],
        borderColor: '#3b82f6',
        backgroundColor: 'rgba(59, 130, 246, 0.1)',
        borderWidth: 3,
        fill: true,
        tension: 0.4,
        pointRadius: 5,
        pointBackgroundColor: '#3b82f6',
        pointBorderColor: '#1e293b',
        pointBorderWidth: 2,
        pointHoverRadius: 7,
      }],
    },
    options: chartOptions,
  });

  // Chart Paiements par Mois
  const paymentData = @json($paymentsByMonth);
  const paymentCtx = document.getElementById('paymentChart').getContext('2d');
  new Chart(paymentCtx, {
    type: 'bar',
    data: {
      labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
      datasets: [{
        label: 'Montant (FCFA)',
        data: [paymentData[1] || 0, paymentData[2] || 0, paymentData[3] || 0, paymentData[4] || 0, paymentData[5] || 0, paymentData[6] || 0, paymentData[7] || 0, paymentData[8] || 0, paymentData[9] || 0, paymentData[10] || 0, paymentData[11] || 0, paymentData[12] || 0],
        backgroundColor: '#10b981',
        borderRadius: 8,
        borderSkipped: false,
      }],
    },
    options: chartOptions,
  });

  // Chart Distribution par Programme
  const programData = @json($studentsByProgram);
  const programCtx = document.getElementById('programChart').getContext('2d');
  new Chart(programCtx, {
    type: 'doughnut',
    data: {
      labels: Object.keys(programData),
      datasets: [{
        data: Object.values(programData),
        backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899'],
        borderColor: '#1e293b',
        borderWidth: 3,
      }],
    },
    options: {
      responsive: true,
      maintainAspectRatio: true,
      plugins: {
        legend: {
          labels: { color: '#cbd5e1', font: { size: 12 } },
          position: 'right',
        },
      },
    },
  });

  // Chart État Financier
  const financialCtx = document.getElementById('financialChart').getContext('2d');
  const totalFees = @json($totalFees);
  const totalCollected = @json($totalCollected);
  const totalRemaining = @json($totalRemaining);

  new Chart(financialCtx, {
    type: 'bar',
    data: {
      labels: ['Total Frais', 'Collecté', 'À Collecter'],
      datasets: [{
        label: 'Montant (FCFA)',
        data: [totalFees, totalCollected, totalRemaining],
        backgroundColor: ['#6366f1', '#10b981', '#f59e0b'],
        borderRadius: 8,
        borderSkipped: false,
      }],
    },
    options: chartOptions,
  });
</script>
