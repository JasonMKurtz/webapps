class CreateRects < ActiveRecord::Migration
  def change
    create_table :rects do |t|
      t.integer :width
      t.integer :height

      t.timestamps
    end
  end
end
