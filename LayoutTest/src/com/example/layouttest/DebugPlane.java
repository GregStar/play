package com.example.layouttest;

import java.util.Vector;

import android.opengl.GLES20;

public class DebugPlane extends BaseObject {
	public DebugPlane() {
		super();
		
		mGLType = GLES20.GL_LINES;
		
		_initData();
		mVertexColorBuffer = _initFloatBuffer2(mVertexColorData);
		
		mStrideBytes = 7 * SIZE_OF_FLOAT;
		mVertexOffset = 0;
		mColorOffset = COORDS_PER_VERTEX;
		
		mVertexColorCount = mVertexColorData.length / 7;
		
		mInitShaders();
		
	}
	
	private float mVertexColorData[];
	
	private void _initData() {
		mVertexColorData = new float[16];
		
		Vector<Float> t = new Vector<Float>();
		
		int dx, dz;
		dx = dz = 100;
		int stepsize = 10;
		
		for( int x = -dx; x <= dx; x=x+stepsize ) {
			t.addElement(Float.valueOf(-dx));
			t.addElement(Float.valueOf(  0));
			t.addElement(Float.valueOf(  x));
			
			t.add(Float.valueOf(0.75f));
			t.add(Float.valueOf(0.5f));
			t.add(Float.valueOf(0.5f));
			t.add(Float.valueOf(1.0f));

			
			t.addElement(Float.valueOf( dx));
			t.addElement(Float.valueOf(  0));
			t.addElement(Float.valueOf(  x));
			
			t.add(Float.valueOf(0.75f));
			t.add(Float.valueOf(0.5f));
			t.add(Float.valueOf(0.5f));
			t.add(Float.valueOf(1.0f));
		}
		
		for( int z = -dz; z <= dz; z=z+stepsize ) {
			t.addElement(Float.valueOf(  z));
			t.addElement(Float.valueOf(  0));
			t.addElement(Float.valueOf(-dz));
			
			t.add(Float.valueOf(0.75f));
			t.add(Float.valueOf(0.5f));
			t.add(Float.valueOf(0.5f));
			t.add(Float.valueOf(1.0f));
			
			
			t.addElement(Float.valueOf(  z));
			t.addElement(Float.valueOf(  0));
			t.addElement(Float.valueOf( dz));
			
			t.add(Float.valueOf(0.75f));
			t.add(Float.valueOf(0.5f));
			t.add(Float.valueOf(0.5f));
			t.add(Float.valueOf(1.0f));
		}
		
		mVertexColorData = Utility.toArray(t);
	}
	
}
