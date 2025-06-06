<x-app-layout>

    <x-slot name="header">

        <h2 class="font-semibold text-xl leading-tight">
            {{ __('User Management') }}
        </h2>
    </x-slot>
    @auth
        <article class="-mx-4 mt-6">
            <header
                class="bg-zinc-700 text-zinc-200 rounded-t-lg -mx-4 -mt-8 p-8 text-2xl font-bold flex flex-row items-center">
                <h2 class="mr-auto max-w-md truncate">
                    Users (List)
                </h2>
                <div class="order-first">
                    <i class="fa-solid fa-user min-w-8 text-white"></i>
                </div>
                <x-primary-link-button href="{{ route('users.create') }}"
                                       class="bg-zinc-200 hover:bg-zinc-900 text-zinc-800 hover:text-white">
                    <i class="fa-solid fa-user-plus "></i>
                    <span class="pl-4">Add User</span>
                </x-primary-link-button>
            </header>


            <div class="flex flex-col flex-wrap my-4 mt-8">
                <section class="grid grid-cols-1 gap-4 px-4 mt-4 sm:px-8">

                    <section class="min-w-full items-center bg-zinc-50 border border-zinc-600 rounded overflow-hidden">

                        <table class="min-w-full text-left text-sm font-light text-surface dark:text-white">
                            <thead
                                class="border-b border-neutral-200 bg-zinc-800 font-medium text-white dark:border-white/10">
                            <tr>
                                <th scope="col" class="px-6 py-4">#</th>
                                <th scope="col" class="px-6 py-4">Name</th>
                                <th scope="col" class="px-6 py-4">eMail</th>
                                <th scope="col" class="px-6 py-4">Role</th>
                                <th scope="col" class="px-6 py-4">Actions</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($users as $user)
                                <tr class="border-b border-zinc-300 dark:border-white/10">
                                    <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $loop->index + 1 }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ $user->given_name }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 w-full">{{ $user->email }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                    <span
                                        class="text-xs text-white bg-zinc-500 px-1 rounded-full min-w-12 inline-block text-center">{{ $user->roles->first()->name}}</span>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <form action="{{ route('users.destroy', $user) }}"
                                              method="POST"
                                              class="flex gap-4">
                                            @csrf
                                            @method('DELETE')


                                            <x-primary-link-button href="{{ route('users.show', $user) }}"
                                                                   class="bg-zinc-700 hover:bg-indigo-700 pr-2 pl-2">
                                                                   {{ __('Show') }}
                                                <i class="fa-solid fa-eye pr-2 order-first"></i>
                                            </x-primary-link-button>
                                            <x-primary-link-button href="{{ route('users.edit', $user) }}"
                                                                   class="bg-zinc-500 hover:bg-indigo-700 pr-2 pl-2">
                                                {{ __('Edit') }}
                                                <i class="fa-solid fa-edit pr-2 order-first"></i>
                                            </x-primary-link-button>
                                            <x-secondary-button type="submit"
                                                                class="!text-gray-700 bg-zinc-200 pr-2 pl-2 hover:bg-red-700 hover:!text-white">
                                                                {{ __('Delete') }}
                                                <i class="fa-solid fa-times pr-2 order-first"></i>
                                            </x-secondary-button>
                                        </form>
                                    </td>
                                </tr>

                            @endforeach
                            </tbody>

                            <tfoot>
                            <tr class="bg-zinc-100">
                                <td colspan="5" class="px-6 py-2">
                                    @if( $users->hasPages() )
                                        {{ $users->links() }}
                                    @elseif( $users->total() === 0 )
                                        <p class="text-xl">No users found</p>
                                    @else
                                        <p class="py-2 text-zinc-800 text-sm">All users shown</p>
                                    @endif
                                </td>
                            </tr>
                            </tfoot>

                        </table>

                    </section>

                </section>

            </div>
        </article>
    @else
        <p class="text-center py-4">You must be logged in to view the users list.</p>
    @endauth
</x-app-layout>
