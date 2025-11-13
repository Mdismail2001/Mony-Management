@extends('layouts.base')

@section('title', 'Dashboard')

@section('content')
  <!-- Navbar -->
<div class="flex flex-col bg-gray-50">
  <header class="bg-indigo-600 text-white shadow">
    <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-4">
      <h1 class="text-2xl font-bold">Money Manager</h1>
      <div class="flex items-center space-x-4">
        <span class="text-sm">Welcome, <strong>User</strong></span>
        <button class="bg-white text-indigo-600 px-3 py-1.5 rounded-md hover:bg-indigo-100 text-sm font-medium">Logout</button>
      </div>
    </div>
  </header>

  <!-- Main Content -->
  <main class="flex-1 max-w-7xl mx-auto p-6">
    <!-- Overview Cards -->
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
      <div class="bg-white p-5 rounded-2xl shadow hover:shadow-lg transition">
        <h2 class="text-sm text-gray-500 mb-2">Total Balance</h2>
        <p class="text-2xl font-semibold text-gray-800">$5,230.00</p>
      </div>
      <div class="bg-white p-5 rounded-2xl shadow hover:shadow-lg transition">
        <h2 class="text-sm text-gray-500 mb-2">Monthly Income</h2>
        <p class="text-2xl font-semibold text-green-500">$2,800.00</p>
      </div>
      <div class="bg-white p-5 rounded-2xl shadow hover:shadow-lg transition">
        <h2 class="text-sm text-gray-500 mb-2">Monthly Expenses</h2>
        <p class="text-2xl font-semibold text-red-500">$1,940.00</p>
      </div>
      <div class="bg-white p-5 rounded-2xl shadow hover:shadow-lg transition">
        <h2 class="text-sm text-gray-500 mb-2">Savings</h2>
        <p class="text-2xl font-semibold text-blue-500">$860.00</p>
      </div>
    </section>

    <!-- Recent Transactions -->
    <section class="bg-white rounded-2xl shadow p-6 mb-8">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold text-gray-800">Recent Transactions</h2>
        <button class="text-sm text-indigo-600 hover:underline">View All</button>
      </div>
      <table class="w-full text-left text-sm">
        <thead class="border-b text-gray-600">
          <tr>
            <th class="pb-3">Date</th>
            <th class="pb-3">Category</th>
            <th class="pb-3">Description</th>
            <th class="pb-3 text-right">Amount</th>
          </tr>
        </thead>
        <tbody class="text-gray-700">
          <tr class="border-b hover:bg-gray-50">
            <td class="py-2">Nov 10, 2025</td>
            <td>Food</td>
            <td>Lunch at Cafe</td>
            <td class="text-right text-red-500">- $12.50</td>
          </tr>
          <tr class="border-b hover:bg-gray-50">
            <td class="py-2">Nov 09, 2025</td>
            <td>Salary</td>
            <td>Monthly Salary</td>
            <td class="text-right text-green-500">+ $2,000.00</td>
          </tr>
          <tr class="border-b hover:bg-gray-50">
            <td class="py-2">Nov 07, 2025</td>
            <td>Utilities</td>
            <td>Electricity Bill</td>
            <td class="text-right text-red-500">- $89.90</td>
          </tr>
        </tbody>
      </table>
    </section>

    <!-- Budget Summary -->
    <section class="bg-white rounded-2xl shadow p-6">
      <h2 class="text-lg font-semibold text-gray-800 mb-4">Budget Summary</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div>
          <h3 class="text-sm text-gray-500 mb-1">Food & Dining</h3>
          <div class="w-full bg-gray-200 rounded-full h-3">
            <div class="bg-green-500 h-3 rounded-full" style="width: 75%"></div>
          </div>
          <p class="text-xs mt-1 text-gray-500">75% used</p>
        </div>
        <div>
          <h3 class="text-sm text-gray-500 mb-1">Transport</h3>
          <div class="w-full bg-gray-200 rounded-full h-3">
            <div class="bg-yellow-500 h-3 rounded-full" style="width: 50%"></div>
          </div>
          <p class="text-xs mt-1 text-gray-500">50% used</p>
        </div>
        <div>
          <h3 class="text-sm text-gray-500 mb-1">Entertainment</h3>
          <div class="w-full bg-gray-200 rounded-full h-3">
            <div class="bg-red-500 h-3 rounded-full" style="width: 30%"></div>
          </div>
          <p class="text-xs mt-1 text-gray-500">30% used</p>
        </div>
      </div>
    </section>
  </main>

  <!-- Footer -->
  <footer class="bg-gray-100 text-center text-sm text-gray-500 py-4 mt-auto">
    © 2025 Money Manager. All rights reserved.
  </footer>
</div>
@endsection
