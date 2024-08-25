import { Link } from '@inertiajs/react'
import React from 'react'

interface LinkType {
    url: string | null;
    label: string;
    active: boolean;
  }
  

const Pagination = ({ links }: { links: LinkType[]}) => {
  return (
    <nav className="text-center mt-4">
      {links.map(link => (
        <Link
          preserveScroll
          href={link.url || ''}
          key={link.label}
          dangerouslySetInnerHTML={{ __html: link.label }}
          className={`inline-block py-2 px-3 rounded-lg text-xs ${
            link.active ? 'bg-gray-200 text-gray-600' : 
            !link.url ? 'text-gray-500 cursor-not-allowed' :
            'hover:bg-gray-100'
          }`}
        />
      ))}
    </nav>
  )
}

export default Pagination