import React from 'react';
import { Head, Link } from '@inertiajs/react';
import {  Response422, Response404, UserResponse } from '@/types';
import Guest from '@/Layouts/GuestLayout';
import Pagination from '@/Components/Pagination';
import User from '@/Components/Users/User';
import NavLink from '@/Components/NavLink';

interface UsersProps {
    userResponse: UserResponse;
    userResponse422?: Response422;
    userResponse404?: Response404;
}

export default function Users({ userResponse, userResponse422, userResponse404 }: UsersProps) {

    const user = userResponse.user;
    return (
        <Guest>
            <Head title="Users" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            {userResponse.success ? (
                                <>
                                    <div className=' text-xl gap-10 border-[1px] border-black p-3 m-1 rounded-md flex justify-between h-[50vh]'>
                                        <div className=' flex flex-col '>
                                            {user.name + ' ID: ' + user.id}
                                            <img src={'/storage/' + user.photo} alt={user.name} className=' border w-[300px] h-auto'/>
                                        </div>

                                        <div className=' flex flex-col w-[30%] text-left gap-6'>
                                        <div>
                                            Email: {user.email}
                                        </div>
                                        <div>
                                            Phone: {user.phone}
                                        </div>
                                        </div>

                                        <div className='flex flex-col'>
                                            {user.position}
                                            <div>
                                            ID: {user.position_id}
                                            </div>
                                        </div>

                                        <div>
                                        With us since {user.email_verified_at?.slice(0, 10)}
                                        </div>
                                    </div>
                                </>
                            ) : 
                                userResponse422 ? (
                                    <div className="text-red-500">
                                        {userResponse422!.message}
                                    </div>

                                    )
                                : userResponse404 ? (
                                    <div className="text-red-500">
                                        <p>{userResponse404!.message}</p>
                                        
                                    </div>

                                )
                                : userResponse422 ? (
                                    <div className="text-red-500">
                                        <p>{userResponse404!.message}</p>
                                        
                                    </div>

                                )
                                : 
                                <div>
                                    Undefined error
                                </div>
                            }
                        </div>
                        <Link href='/users'>
                        <p>
                        &lt;&lt;Go back
                        </p>
                        </Link>
                        
                    </div>
                </div>
            </div>
        </Guest>
    );
}
