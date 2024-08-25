import ApplicationLogo from '@/Components/ApplicationLogo';
import NavLink from '@/Components/NavLink';
import { Link } from '@inertiajs/react';
import { PropsWithChildren } from 'react';

export default function Guest({ children }: PropsWithChildren) {
    return (
        <div className="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 p-2">
            <div>
                <NavLink href={route('dashboard')} active={route().current('dashboard')}>
                    Dashboard
                </NavLink>
                <NavLink href={route('users.index')} active={route().current('users.index')}>
                    Users
                </NavLink>
                <NavLink href={route('positions.index')} active={route().current('positions.index')}>
                    Positions
                </NavLink>
            </div>

            <div className="w-full mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {children}
            </div>
        </div>
    );
}
