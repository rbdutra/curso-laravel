<div class="flex gap-2 mt-4 text-sm">
    <div x-data="{ open: false }">
        <button @click="open = ! open" class="bg-slate-200 text-black px-4 py-2 rounded-md">
            <img src="https://www.alpinejs.dev/alpine_long.svg" class="w-[50px] md:w-[85px]" alt="">
        </button>

        <div x-show="open" x-data="{ count: 0 }" class="flex justify-center p-6 bg-gray-100 dark:bg-gray-800 rounded-lg shadow-md text-center m-5 border-gray-200 dark:border-gray-700">
            <h1 class="text-md">Alpine.js</h1>
            <button class="bg-green-500 text-white border-2 w-10 rounded-md" x-on:click="count--">-</button>

            <h1 class="text-2xl mx-10" x-text="count"></h1>

            <button class="bg-red-500 text-white border-2 w-10 rounded-md" x-on:click="count++">+</button>
        </div>
    </div>







    <div x-data="{ open: false }">
        <button @click="open = ! open" class="bg-slate-200 text-white px-4 py-2 rounded-md">
            <img src="https://raw.githubusercontent.com/livewire/livewire/main/art/readme_logo.png" class="w-[50px] md:w-[60px]" alt="">
        </button>

        <div x-show="open">
            <div class="flex justify-center p-6 bg-slate-200 dark:bg-gray-800 rounded-lg shadow-md text-center m-5 border-gray-200 dark:border-gray-700">
                <h1 class="text-md">Livewire</h1>
                <button class="bg-green-500 text-white border-2 w-10 rounded-md" wire:click="decrement">-</button>

                <h1 class="text-2xl mx-10">{{ $count }}</h1>

                <button class="bg-red-500 text-white border-2 w-10 rounded-md" wire:click="increment">+</button>

            </div>

            <div class="flex flex-col justify-center p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md text-center m-5 border-gray-200 dark:border-gray-700">
                <div>
                    <input type="text" class="border-2 border-gray-300 rounded-md p-2 w-60 text-center" wire:model="name" placeholder="Enter name">

                    <button class="bg-sky-500 text-white border-2 w-auto px-4 py-1 rounded-md" wire:click="save">Salvar</button>
                </div>
                <div>
                    <ul>
                        @foreach ($dados as $dado)
                        <li class="text-lg font-semibold">{{ $dado['name'] }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
