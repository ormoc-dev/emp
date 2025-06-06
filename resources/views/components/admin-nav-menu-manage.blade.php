@props(['activeRoute' => null])

<ul
    class="hidden text-sm font-medium text-center text-gray-500 rounded-lg shadow sm:flex dark:divide-gray-700 dark:text-gray-400">
    <li class="w-full focus-within:z-10">
        <a class="inline-block w-full p-4 {{ request()->routeIs('events.create') ? 'text-gray-900 bg-gray-100 dark:bg-gray-700 dark:text-white' : 'bg-white hover:text-gray-700 hover:bg-gray-50 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700' }} border-r border-gray-200 dark:border-gray-700 rounded-s-lg focus:ring-4 focus:ring-blue-300 active focus:outline-none"
            href="{{ route('events.create') }}"
            aria-current="{{ request()->routeIs('events.create') ? 'page' : 'false' }}" wire:navigate>
            <span class="box_hand"> <i class="fa-regular fa-hand-point-right"></i></span>
            ADD EVENTS
        </a>
    </li>
    <li class="w-full focus-within:z-10">
        <a class="inline-block w-full p-4 {{ request()->routeIs('register_judge') ? 'text-gray-900 bg-gray-100 dark:bg-gray-700 dark:text-white' : 'bg-white hover:text-gray-700 hover:bg-gray-50 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700' }} border-r border-gray-200 dark:border-gray-700 focus:ring-4 focus:ring-blue-300 focus:outline-none"
            href="{{ route('register_judge') }}" wire:navigate>ASSIGN JUDGE</a>
    </li>
    <li class="w-full focus-within:z-10">
        <a class="inline-block w-full p-4 {{ request()->routeIs('select.event') ? 'text-gray-900 bg-gray-100 dark:bg-gray-700 dark:text-white' : 'bg-white hover:text-gray-700 hover:bg-gray-50 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700' }} border-r border-gray-200 dark:border-gray-700 focus:ring-4 focus:ring-blue-300 focus:outline-none"
            href="{{ route('select.event') }}" wire:navigate>ADD CONTESTANTS</a>
    </li>
    <li class="w-full focus-within:z-10">
        <a class="inline-block w-full p-4 {{ request()->routeIs('selectS.event') ? 'text-gray-900 bg-gray-100 dark:bg-gray-700 dark:text-white' : 'bg-white hover:text-gray-700 hover:bg-gray-50 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700' }} border-s-0 border-gray-200 dark:border-gray-700 rounded-e-lg focus:ring-4 focus:outline-none focus:ring-blue-300"
            href="{{ route('selectS.event') }}" wire:navigate>ADD CRITERIA</a>
    </li>
</ul>
