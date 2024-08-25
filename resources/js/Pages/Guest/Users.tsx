import React, { useState } from 'react';
import { Head } from '@inertiajs/react';
import { UsersResponse } from '@/types';
import Guest from '@/Layouts/GuestLayout';
import Pagination from '@/Components/Pagination';
import User from '@/Components/Users/User';

interface UsersProps {
    usersResponse: UsersResponse;
}

export default function Users({ usersResponse }: UsersProps) {
    const { users, page, count, total_pages, total_users, success } = usersResponse;

    return (
        <Guest>
            <Head title="Users" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            {success ? (
                                <>
                                    <p className="text-gray-500">Current Page: {page}</p>
                                    <p className="text-gray-500">Total Users: {total_users}</p>
                                    <p className="text-gray-500">Total Pages: {total_pages}</p>
                                    {users.data.map((user, index) => (
                                        <div key={index}>
                                            <User user={user} />
                                        </div>
                                    ))}
                                </>
                            ) : (
                                <p className="text-red-500">Failed to fetch data.</p>
                            )}
                        </div>
                        <form action="/users" >
                            <label htmlFor="perPage">Users per page</label>
                            <input
                                id="perPage"
                                name='perPage'
                                type="number"
                                className='m-2 p-2 rounded-md'
                                defaultValue={count}
                            />
                            <button type='submit'>Apply</button>
                        </form>
                        <Pagination links={users.meta.links} />
                    </div>
                </div>
            </div>
        </Guest>
    );
}
