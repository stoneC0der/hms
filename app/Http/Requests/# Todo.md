# Todo

Step to resolve updating room availability when updating booking, creating seams to work

## Sudo code

- get old room_infos
- get new room_infos
- if old_room != new_room
  - if new_room is single
    - mark as full
    - mark old room has available (persist)
  - if new_room is double
    - mark old_room as available (persist)
    - if new_room exists in booking
      - mark it has unavailable

## Implementation

```php
...
$updated_book_details = []; // Incoming booking info
// The room type info extracted using incoming booking room price
$booking = $booking; // The current booking model;
$new_room = Room::find($updated_book_details['room_id']);
$old_room = $booking->room;

if ($new_room != $old_room) {
    setRoomAvailability($new_room, $old_room);
}

/**
 * Set room availability based on type
 *
 * @param Model|Collection|Builder[]|Builder|null $new_room the incoming room
 * @param Model|Collection|Builder[]|Builder|null $old_room the current room
 */
public function setRoomAvailability($new_room, $old_room):void
{
    if ($new_room->room->type->type == 'single') {
        $new_room->is_available = boolVal(false);
        $old_room->is_available = boolVal(true);
    } else {
        $old_room->is_available = boolVal(true);
        $new_room_exists = Booking::where('room_id', $new_room->id)->count();
        if ($new_room_exists >= 1) {
            $new_room->is_available = boolVal(false);
        }
    }
    $old_room->save();
    $new_room->save();
}
