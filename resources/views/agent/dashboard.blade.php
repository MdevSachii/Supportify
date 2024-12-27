<x-app-layout>
    <div class="py-12" x-data=customerTickets()>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white h- overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-wrap justify-center gap-2">
                        <form class="flex items-center w-full sm:max-w-sm">
                            <label for="simple-search" class="sr-only">Search</label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <i class="fa-solid fa-ticket"></i>
                                </div>
                                <input type="text" id="simple-search"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5"
                                    placeholder="Search branch name..." required />
                            </div>
                            <button type="submit"
                                class="p-2.5 ml-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                <i class="fa-solid fa-magnifying-glass"></i>
                                <span class="sr-only">Search</span>
                            </button>
                        </form>
                    </div>

                    <div class="mt-10 flex flex-wrap justify-center">
                        <button @Click="openTicketView()" class="w-full sm:w-1/2 md:w-1/3 p-2">
                            <div
                                class="relative px-6 py-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
                                <span
                                    class="absolute -top-2 -end-2 bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded">Pending</span>
                                <div>
                                    <div class="flex justify-between">
                                        <p class="font-normal text-xs text-gray-500">#123456789</p>
                                        <p class="font-normal text-xs text-gray-500">22:18 27/12/2024</p>
                                    </div>
                                    <h5 class="mt-2 text-2xl font-bold tracking-tight text-gray-900">Shehara
                                        Thrimavithana</h5>
                                    <p class="font-normal text-xs text-gray-500">work.thrima@gmail.com</p>
                                </div>
                            </div>
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <template x-if="isModelOpen">
            <div class="flex min-h-full items-center justify-center p-4 text-center">
                <div class="fixed inset-0 bg-gray-500/75 transition-opacity"></div>
                <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                        <div>
                            <div class="mt-10 flex justify-center">
                                <div
                                    class="relative max-w-md px-6 py-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
                                    <span
                                        class="absolute -top-2 -end-2 bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded">Pending</span>
                                    <div>
                                        <div class="flex justify-between">
                                            <p class="font-normal text-xs text-gray-500">#123456789</p>
                                            <p class="font-normal text-xs text-gray-500">22:18 27/12/2024</p>
                                        </div>

                                        <h5 class="text-left mt-2 text-2xl font-bold tracking-tight text-gray-900">
                                            Shehara Thrimavithana
                                        </h5>
                                        <p class="text-left font-normal text-xs text-gray-500">work.thrima@gmail.com</p>

                                        <p class="text-left mt-2 font-normal text-gray-700">Here are the biggest
                                            enterprise
                                            technology acquisitions of 2021 so far, in reverse chronological order.</p>
                                    </div>

                                    <div class="relative mt-5 p-4 border border-gray-300 rounded-lg bg-gray-50">
                                        <div class="absolute -top-2 -start-2">
                                            <i class="fa-brands fa-rocketchat"></i>
                                        </div>

                                        <div class="flex justify-between">
                                            <h3 class="text-lg font-medium text-gray-800">Sachini
                                                Wijesinghe</h3>
                                            <p class="font-normal text-xs text-gray-500 self-center">22:18 27/12/2024
                                            </p>
                                        </div>
                                        <div class="text-left mt-2 mb-4 text-sm text-gray-800">
                                            More info about this info dark goes here. This example text is going to run
                                            a bit
                                            longer so that you can see how spacing within an alert works with this kind
                                            of
                                            content.
                                        </div>
                                    </div>

                                    <form>
                                        <div class="my-4">
                                            <textarea id="message" rows="4"
                                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                                placeholder="Reply place here..." required></textarea>
                                            <div class="flex gap-5 mt-4">
                                                <button @click="isModelOpen=false" type="button"
                                                    class="text-white bg-gray-500 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center">Close</button>

                                                <button type="submit"
                                                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center">Open
                                                    Ticket</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <script>
            function customerTickets() {
                return {
                    isModelOpen: false,

                    openTicketView() {
                        this.isModelOpen = true;
                    }
                }
            }
        </script>
    </div>
</x-app-layout>
