package com.example.layouttest;

import java.util.Vector;

import android.opengl.GLES20;
import android.util.Log;

public class Utility {

	public static void checkGLError( String op ) {
        int error;
        while ((error = GLES20.glGetError()) != GLES20.GL_NO_ERROR) {
            Log.e("AAA", op + ": glError " + error);
            throw new RuntimeException(op + ": glError " + error);
        }
	}
	
	public static void logGLErrors( String op ) {
        int error;
        while ((error = GLES20.glGetError()) != GLES20.GL_NO_ERROR) {
            Log.e("AAA", op + ": glError " + error);
        }
	}
	
	public static void checkHandle( int handle, String name ) {
		if( handle == -1 )
			throw new RuntimeException( "handle" + name + " is invalid" );
	}

	public static float[] toArray( Vector<Float> in ) {
		float[] out = new float[ in.size() ];
		for( int i=0; i < in.size(); ++i ) {
			out[i] = in.get(i);
		}
		return out;
	}
	
}
