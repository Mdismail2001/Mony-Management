@extends('layouts.base')

@section('title', 'Admin Dashboard')

@section('content')
<div class="flex  bg-gray-50">
  <!-- Sidebar -->
  <aside class="w-64 bg-indigo-700 text-white flex flex-col p-5 space-y-4">
    <h2 class="text-2xl font-bold mb-6">Money Manager</h2>
    <nav class="flex flex-col space-y-2">
      <a href="#" class="bg-indigo-600 px-3 py-2 rounded-md">Dashboard</a>
      <a href="#" class="hover:bg-indigo-600 px-3 py-2 rounded-md">Users</a>
      <a href="#" class="hover:bg-indigo-600 px-3 py-2 rounded-md">Transactions</a>
      <a href="#" class="hover:bg-indigo-600 px-3 py-2 rounded-md">Categories</a>
      <a href="#" class="hover:bg-indigo-600 px-3 py-2 rounded-md">Reports</a>
      <a href="#" class="hover:bg-indigo-600 px-3 py-2 rounded-md">Settings</a>
    </nav>
    <div class="mt-auto pt-6 border-t border-indigo-500">
      <button class="w-full bg-red-600 px-3 py-2 rounded-md hover:bg-red-700 text-sm font-medium">Logout</button>
    </div>
  </aside>

  <!-- Main Content -->
  <main class="flex-1 p-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
      <h1 class="text-2xl font-bold text-gray-800">Admin Dashboard</h1>
      <div class="flex items-center space-x-4">
        <input type="text" placeholder="Search..." class="border rounded-lg px-3 py-1.5 text-sm focus:outline-indigo-500">
        <button class="relative p-2 bg-gray-100 rounded-full hover:bg-gray-200">
          🔔
          <span class="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full px-1">3</span>
        </button>
        <div class="bg-gray-100 px-3 py-1.5 rounded-lg text-sm">Admin</div>
      </div>
    </div>

    <!-- Overview Cards -->
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
      <div class="bg-white shadow rounded-xl p-5 border-l-4 border-indigo-500">
        <h2 class="text-sm text-gray-500">Total Users</h2>
        <p class="text-2xl font-semibold text-gray-800 mt-1">124</p>
      </div>
      <div class="bg-white shadow rounded-xl p-5 border-l-4 border-green-500">
        <h2 class="text-sm text-gray-500">Total Income</h2>
        <p class="text-2xl font-semibold text-green-600 mt-1">$82,430</p>
      </div>
      <div class="bg-white shadow rounded-xl p-5 border-l-4 border-red-500">
        <h2 class="text-sm text-gray-500">Total Expenses</h2>
        <p class="text-2xl font-semibold text-red-600 mt-1">$67,980</p>
      </div>
      <div class="bg-white shadow rounded-xl p-5 border-l-4 border-yellow-500">
        <h2 class="text-sm text-gray-500">Active Transactions</h2>
        <p class="text-2xl font-semibold text-gray-800 mt-1">890</p>
      </div>
    </section>

    <!-- Charts / Reports Section -->
    <section class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
      <div class="bg-white shadow rounded-xl p-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Monthly Income vs Expenses</h3>
        <div class="w-full h-64 flex items-center justify-center text-gray-400 text-sm">
          [ Chart Placeholder ]
        </div>
      </div>
      <div class="bg-white shadow rounded-xl p-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Top Spending Categories</h3>
        <ul class="text-sm text-gray-600 space-y-3">
          <li class="flex justify-between"><span>Food & Dining</span><span class="font-semibold">$12,430</span></li>
          <li class="flex justify-between"><span>Utilities</span><span class="font-semibold">$8,120</span></li>
          <li class="flex justify-between"><span>Transportation</span><span class="font-semibold">$5,780</span></li>
          <li class="flex justify-between"><span>Shopping</span><span class="font-semibold">$4,600</span></li>
        </ul>
      </div>
    </section>

    <!-- Recent User Activity -->
    <section class="bg-white shadow rounded-xl p-6">
      <h3 class="text-lg font-semibold text-gray-700 mb-4">Recent User Activities</h3>
      <table class="w-full text-sm">
        <thead class="border-b text-gray-600">
          <tr>
            <th class="text-left py-2">User</th>
            <th class="text-left py-2">Activity</th>
            <th class="text-left py-2">Date</th>
          </tr>
        </thead>
        <tbody class="text-gray-700">
          <tr class="border-b hover:bg-gray-50">
            <td class="py-2">John Doe</td>
            <td>Added new transaction</td>
            <td>Nov 10, 2025</td>
          </tr>
          <tr class="border-b hover:bg-gray-50">
            <td class="py-2">Mary Smith</td>
            <td>Updated category</td>
            <td>Nov 09, 2025</td>
          </tr>
          <tr class="border-b hover:bg-gray-50">
            <td class="py-2">Ali Khan</td>
            <td>Deleted expense record</td>
            <td>Nov 08, 2025</td>
          </tr>
        </tbody>
      </table>
    </section>
  </main>
</div>
@endsection
