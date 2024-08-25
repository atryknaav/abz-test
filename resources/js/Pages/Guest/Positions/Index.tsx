import Guest from '@/Layouts/GuestLayout';
import React from 'react'

interface Position {
    id: number;
    name: string;
}

interface IndexProps {
    positions: Position[];
}

const Index = ({ positions }: IndexProps) => {
  return (
    <Guest>
    <div>
        {positions.map((position) => (
            <div key={position.id} className=' border-2 m-3 rounded-xl p-3'>
                <p>ID: {position.id}</p>
                <p>Name: {position.name}</p>
            </div>
        ))}
    </div>
    </Guest>
  )
}

export default Index
