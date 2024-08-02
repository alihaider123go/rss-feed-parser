<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">                
                    <div>
                        <a href="{{ route('zaptaps.create') }}" class="btn btn-primary" role="button" aria-pressed="true">Add New</a>
                        <table class="table table-striped table-hover table-reflow">
                            <thead>
                                <tr>
                                    <th ><strong> Name: </strong></th>
                                    <th ><strong> Surname: </strong></th>
                                    <th ><strong> Email: </strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td> John </td>
                                    <td> Doe </td>
                                    <td> john.doe@email.com </td>
                                </tr>
                                <tr>
                                    <td> Joane </td>
                                    <td> Donald </td>
                                    <td> jane@email.com </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
